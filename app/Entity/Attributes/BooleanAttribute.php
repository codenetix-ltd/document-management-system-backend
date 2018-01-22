<?php

namespace App\Entity\Attributes;
use App\Contracts\Entity\IHasBooleanValue;
use App\Traits\Entity\HasBooleanValue;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class BooleanAttribute extends AAttribute implements IHasBooleanValue
{
    use HasBooleanValue;

    public function getTypeName() : string
    {
        return 'boolean';
    }

}