<?php

namespace App\Entity\Attributes;

use App\Contracts\Entity\IHasNumericValue;
use App\Traits\Entity\HasNumericValue;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class NumericAttribute extends AAttribute implements IHasNumericValue
{
    use HasNumericValue;

    public function __construct($id, $name, $typeId, $typeName, $isLocked)
    {
        parent::__construct($id, $name, $typeId, $typeName, $isLocked);
    }

    public function getTypeName() : string
    {
        return 'numeric';
    }
}