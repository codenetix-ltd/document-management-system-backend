<?php

namespace App\Contracts\Entity;

use App\Entity\ValueWithDeviations;

interface IHasValueWithDeviationsValue
{
    public function getValue() : ValueWithDeviations;
    public function setValue(ValueWithDeviations $string) : void;
}