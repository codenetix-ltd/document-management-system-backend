<?php

namespace App\Contracts\Services\Attribute;

use App\Attribute;

interface IAttributeGetService
{
    public function get(int $id) : Attribute;
}