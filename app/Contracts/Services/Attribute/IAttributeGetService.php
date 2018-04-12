<?php

namespace App\Contracts\Services\Attribute;

use App\Contracts\Models\IAttribute;

interface IAttributeGetService
{
    public function get(int $id) : IAttribute;
}