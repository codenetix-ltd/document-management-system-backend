<?php

namespace App\Contracts\Entity;

use App\Entity\Attributes\ATable;

interface IHasTableValue
{
    public function getValue() : ATable;

    public function setValue(ATable $string) : void;
}