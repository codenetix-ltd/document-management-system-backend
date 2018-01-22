<?php

namespace App\Contracts\Entity;

use Illuminate\Support\Collection;

interface IHasCollectionValue
{
    public function getValue() : Collection;

    public function setValue(Collection $collection) : void;
}