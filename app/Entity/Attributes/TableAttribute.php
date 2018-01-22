<?php

namespace App\Entity\Attributes;
use App\Contracts\Entity\IHasTableValue;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TableAttribute extends AAttribute implements IHasTableValue
{
    private $value;

    public function getTypeName() : string
    {
        return 'table';
    }

    public function getValue() : ATable
    {
        return $this->value;
    }

    public function setValue(ATable $value) : void
    {
        $this->value = $value;
    }
}