<?php

namespace App\Contracts\Services\Attribute;

use App\Attribute;
use App\Exceptions\InvalidAttributeDataStructureException;

interface IAttributeTypeTableValidator
{
    /**
     * @param Attribute $attribute
     * @return bool
     * @throws InvalidAttributeDataStructureException
     */
    public function validate(Attribute $attribute): bool;
}