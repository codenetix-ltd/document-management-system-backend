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
}