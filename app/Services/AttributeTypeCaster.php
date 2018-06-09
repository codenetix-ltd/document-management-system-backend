<?php

namespace App\Services;

use App\Entities\AttributeValue;

class AttributeTypeCaster
{
    /**
     * @param AttributeValue $attributeValue
     * @return boolean|float|string
     */
    public static function getValue(AttributeValue $attributeValue)
    {
        switch ($attributeValue->attribute->type->machineName) {
            case TypeService::TYPE_NUMERIC:
                return floatval($attributeValue->value);
            case TypeService::TYPE_BOOLEAN:
                return boolval($attributeValue->value);
            default:
                return $attributeValue->value;
        }
    }
}
