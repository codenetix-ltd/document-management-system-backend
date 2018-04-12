<?php

namespace App\Repositories;

use App\Attribute;
use App\AttributeValue;
use App\Contracts\Models\IAttribute;
use App\Contracts\Models\ITableTypeColumn;
use App\Contracts\Models\ITableTypeRow;
use App\Contracts\Repositories\IAttributeRepository;
use App\TableTypeColumn;
use App\TableTypeRow;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AttributeRepository implements IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId)
    {
        return AttributeValue::whereDocumentVersionId($documentVersionId)->get();
    }

    public function create(IAttribute $attribute): IAttribute
    {
        $order = $this->getDefaultAttributeOrderByTemplateId($attribute->getTemplateId());
        $attribute->setOrder($order);
        $attribute->save();

        $attribute = Attribute::findOrFail($attribute->getId());

        return $attribute;
    }

    public function createTableTypeColumn(int $parentAttributeId, string $name): ITableTypeColumn
    {
        $tableTypeColumn = new TableTypeColumn();
        $tableTypeColumn->setParentAttributeId($parentAttributeId);
        $tableTypeColumn->setName($name);
        $tableTypeColumn->save();

        return $tableTypeColumn;
    }

    public function createTableTypeRow(int $parentAttributeId, string $name): ITableTypeRow
    {
        $tableTypeRow = new TableTypeRow();
        $tableTypeRow->setParentAttributeId($parentAttributeId);
        $tableTypeRow->setName($name);
        $tableTypeRow->save();

        return $tableTypeRow;
    }

    private function getDefaultAttributeOrderByTemplateId(int $templateId)
    {
        $maxOrder = Attribute::where('template_id', $templateId)->where('parent_attribute_id', null)->max('order');

        if (is_null($maxOrder)) {
            return 0;
        } else {
            return $maxOrder + 1;
        }
    }

    public function findOrFail(int $id): IAttribute
    {
        return Attribute::findOrFail($id);
    }

    public function find(int $id): ?IAttribute
    {
        return Attribute::find($id);
    }

    public function getTableRowsByAttributeId(int $id): Collection
    {
        return TableTypeRow::where('parent_attribute_id', $id)->get();
    }

    public function getTableColumnsByAttributeId(int $id): Collection
    {
        return TableTypeColumn::where('parent_attribute_id', $id)->get();
    }

    public function getChildAttributes(int $id): Collection
    {
        return Attribute::where('parent_attribute_id', $id)->get();
    }

    public function delete(int $id): ?bool
    {
        return Attribute::where('id', $id)->delete();
    }

    public function list(): LengthAwarePaginator
    {
        return Attribute::where('parent_attribute_id', null)->paginate();
    }
}