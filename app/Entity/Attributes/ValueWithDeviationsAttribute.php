<?php

namespace App\Entity\Attributes;
use App\Contracts\Entity\IHasValueWithDeviationsValue;
use App\Entity\ValueWithDeviations;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class ValueWithDeviationsAttribute extends AAttribute implements IHasValueWithDeviationsValue
{
    private $value;

    public function __construct($id, $name, $typeId, $typeName, $isLocked)
    {
        parent::__construct($id, $name, $typeId, $typeName, $isLocked);
        $this->value = new ValueWithDeviations();
    }

    public function getTypeName() : string
    {
        return 'value_with_deviations';
    }

    public function getValue() : ValueWithDeviations
    {
        return $this->value;
    }

    public function setValue(ValueWithDeviations $value) : void
    {
        $this->value = $value;
    }
}