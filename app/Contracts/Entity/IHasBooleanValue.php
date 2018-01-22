<?php

namespace App\Contracts\Entity;

interface IHasBooleanValue
{
    public function getValue() : ?bool;
    public function setValue(bool $string) : void;
}