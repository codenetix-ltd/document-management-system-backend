<?php

namespace App\Contracts\Entity;

interface IHasNumericValue
{
    public function getValue() : ?string;

    public function setValue(string $string) : void;
}