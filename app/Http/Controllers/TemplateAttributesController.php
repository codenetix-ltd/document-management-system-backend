<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeValue;
use App\Document;
use App\DocumentVersion;
use App\Events\Template\TemplateUpdateEvent;
use App\Factory;
use App\File;
use App\TableTypeColumn;
use App\TableTypeRow;
use App\Tag;
use App\Template;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemplateAttributesController extends Controller
{

    public function create($temlateId, Request $request)
    {
        $types = Type::all();
        $template = Template::findOrFail($temlateId);

        $typeId = old('type_id');
        if ($typeId) {
            $type = Type::find($typeId);
            $typeSpecifiedForm = $this->getTypeFormByTypeMachineName($type->machine_name, null, false);
        }

        return view('pages.template_attributes.add_edit', compact('types', 'template', 'typeSpecifiedForm'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $attribute = Attribute::findOrFail($id);

        if($attribute->attributeValues->count()){
            return back()->with('error', 'Unable to remove attribute "' . $attribute->name . '" as long as it has at least one document version which use it!');
        }

        $attribute->delete();
        event(new TemplateUpdateEvent(Auth::user(), $attribute->template));

        return back()->with('success', 'Attribute "' . $attribute->name . '" has been removed with success!');
    }

    private function getTypeFormByTypeMachineName($machineName, $attribute = null, $useStackWrapper)
    {
        $viewName = 'partials.type_forms.' . $machineName;
        if (view()->exists($viewName)) {
            //TODO
            $args = [];
            if($attribute && $attribute->type->machine_name == 'table'){
                $tableStructure = $this->buildTableStructure($attribute);
                $args['tableStructure'] = $tableStructure;
            }
            if($useStackWrapper){
                $args['viewName'] = $viewName;
                return view('partials.stack_wrapper', $args);
            } else {
                return view($viewName, $args);
            }
        }
    }

    public function typeForm(Request $request){
        $attributeId = $request->query('attribute_id');
        $typeId = $request->query('type_id');
        $type = Type::findOrFail($typeId);

        if($attributeId){
            $attribute = Attribute::findOrFail($attributeId);
            return $this->getTypeFormByTypeMachineName($type->machine_name, $attribute, true);
        } else {
            return $this->getTypeFormByTypeMachineName($type->machine_name, null, true);
        }
    }

    public function edit($temlateId, $attributeId, Request $request)
    {
        $types = Type::all();
        $template = Template::findOrFail($temlateId);
        $attribute = Attribute::findOrFail($attributeId);

        $typeId = old('type_id', $attribute->type_id);
        if ($typeId) {
            $type = Type::find($typeId);
            $typeSpecifiedForm = $this->getTypeFormByTypeMachineName($type->machine_name, $attribute, false);
        }

        return view('pages.template_attributes.add_edit', compact('types', 'template', 'attribute', 'typeSpecifiedForm'));
    }

    private function buildTableStructure($attribute, $fetchDependencies = false){
        $attributes = Attribute::whereParentAttributeId($attribute->id)->get()->toArray();
        $columns = TableTypeColumn::whereParentAttributeId($attribute->id)->get()->toArray();
        $rows = TableTypeRow::whereParentAttributeId($attribute->id)->get()->toArray();

        $attributesByRowId = [];
        foreach ($attributes as $currentAttribute){
            $attributesByRowId[intval($currentAttribute['table_type_row_id'])][] = $currentAttribute;
        }

        $result = [];
        $result['columns'] = array_map(function($item){
            return [
                'id' => intval($item['id']),
                'name' => $item['name'],
                'type_id' => $item['type_id']
            ];
        }, $columns);

        $result['rows'] = array_map(function($item) use ($attributesByRowId, $fetchDependencies) {
            return [
                'id' => intval($item['id']),
                'name' => $item['name'],
                'data' =>  array_values(array_map(function($item) use($fetchDependencies) {
                    return [
                        'id' => intval($item['id']),
                        'is_locked' => boolval($item['is_locked']),
                        'type_id' => $item['type_id'],
                        'attribute' => $fetchDependencies ? Attribute::findOrFail($item['id']) : null
                    ];
                }, $attributesByRowId[intval($item['id'])]))
            ];
        }, $rows);

        return $result;
    }

    public function store($templateId, Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|unique:attributes|max:255',
            'type_id' => 'required|exists:types,id',
        ]);

        $attribute = DB::transaction(function () use ($request, $templateId) {
            $data = $request->input();
            $attribute = Attribute::create(array_merge($data, ['template_id' => $templateId]));
            event(new TemplateUpdateEvent(Auth::user(), $attribute->template));
            $type = Type::findOrFail($request->input('type_id'));
            if($type->machine_name == 'table'){
                $tableStructure = json_decode($request->input('table_structure'), true);
                $this->createOrUpdateTableStructure($attribute->id, $attribute->template_id, $attribute->name, $tableStructure);
            }
            return $attribute;
        });

        return redirect()
            ->route('templates.edit', ['templateId' => $templateId])
            ->with('success', 'Attribute "' . $attribute->name . '" has been created!');
    }

    /**
     * @param $attributeId
     * @param $attributeName
     * @param $tableStructure
     */
    private function createOrUpdateTableStructure($attributeId, $templateId, $attributeName, $tableStructure)
    {
        TableTypeRow::whereIn('id', $tableStructure['removed_rows'])->delete();
        TableTypeColumn::whereIn('id', $tableStructure['removed_columns'])->delete();

        $columnIds = [];
        foreach ($tableStructure['columns'] as $columnId => $currentColumn) {
            $currentColumn['parent_attribute_id'] = $attributeId;
            if(isset($currentColumn['id'])){
                $column = TableTypeColumn::findOrFail($currentColumn['id']);
                $column->fill($currentColumn);
                $column->update();
            } else {
                $column = TableTypeColumn::create($currentColumn);
            }
            $columnIds[] = $column->id;
        }

        foreach ($tableStructure['rows'] as $rowId => $currentRow) {
            $currentRow['parent_attribute_id'] = $attributeId;
            if(isset($currentRow['id'])){
                $row = TableTypeRow::findOrFail($currentRow['id']);
                $row->fill($currentRow);
                $row->update();
            } else {
                $row = TableTypeRow::create($currentRow);
            }

            foreach ($currentRow['data'] as $columnId => $currentCell) {
                $name = $attributeName . ' / ' . $currentRow['name'] . ' ' . $tableStructure['columns'][$columnId]['name'];

                if(!empty($currentCell['type_id'])){
                    $type = $currentCell['type_id'];
                } else {
                    $type = $tableStructure['columns'][$columnId]['type_id'];
                }

                $attributeData = [
                    'template_id' => $templateId,
                    'name' => $name,
                    'type_id' => $type,
                    'order' => 0,
                    'table_type_row_id' => $row->id,
                    'table_type_column_id' => $columnIds[$columnId],
                    'parent_attribute_id' => $attributeId,
                    'is_locked' => $currentCell['is_locked']
                ];

                if(isset($currentCell['id'])){
                    $attribute = Attribute::findOrFail($currentCell['id']);
                    $attribute->fill($attributeData);
                    $attribute->update();
                } else {
                    Attribute::create($attributeData);
                }
            }
        }
    }

    public function update($templateId, $attributeId, Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|unique:attributes,name,'.$attributeId.'|max:255',
            'type_id' => 'required|exists:types,id',
        ]);

        $attribute = DB::transaction(function () use ($request, $templateId, $attributeId) {
            $data = $request->input();

            $attribute = Attribute::find($attributeId);
            $attribute->fill($data);
            $attribute->update();
            event(new TemplateUpdateEvent(Auth::user(), $attribute->template));

            $type = Type::findOrFail($request->input('type_id'));
            if ($type->machine_name == 'table') {
                $tableStructure = json_decode($request->input('table_structure'), true);
                $this->createOrUpdateTableStructure($attribute->id, $attribute->template_id, $attribute->name, $tableStructure);
            }

            return $attribute;
        });

        return redirect()
            ->route('template_attributes.edit', ['templateId' => $templateId, 'id' => $attribute->id])
            ->with('success', 'Attribute "' . $attribute->name . '" has been updated!');
    }
}
