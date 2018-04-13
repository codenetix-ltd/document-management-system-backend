<?php

namespace App\Contracts\Services\Attribute;

use App\Attribute;

interface IAttributeCreateService
{
    public function create(Attribute $attribute, int $templateId) : Attribute;
}