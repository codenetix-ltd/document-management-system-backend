<?php

namespace App\Entity\Attributes;

use App\Contracts\Entity\IHasStringValue;
use App\Traits\Entity\HasStringValue;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class StringAttribute extends AAttribute implements IHasStringValue
{
    use HasStringValue;

    public function getTypeName() : string
    {
        return 'string';
    }
}