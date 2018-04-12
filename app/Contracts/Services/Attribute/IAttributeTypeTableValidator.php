<?php

namespace App\Contracts\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Exceptions\InvalidAttributeDataStructureException;

interface IAttributeTypeTableValidator
{
    /**
     * @param IAttribute $attribute
     * @return bool
     * @throws InvalidAttributeDataStructureException
     */
    public function validate(IAttribute $attribute): bool;
}