<?php

namespace App\Contracts\Services\Attribute;

use App\Contracts\Models\IAttribute;

interface IAttributeCreateService
{
    public function create(IAttribute $attribute, int $templateId) : IAttribute;
}