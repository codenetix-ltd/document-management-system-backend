<?php

namespace App\Http\Requests\Attribute;

use App\Attribute;
use App\Http\Requests\ApiRequest;

abstract class AttributeBaseRequest extends ApiRequest
{
    public function getEntity(): Attribute
    {
        return $this->transform(Attribute::class);
    }
}