<?php

namespace App\Contracts\Entity;

interface IHasStringValue
{
    public function getValue() : ?string;

    public function setValue(string $string) : void;
}