<?php

namespace App\Http\Requests\Attribute;

use App\Contracts\Models\IAttribute;
use App\Http\Requests\ApiRequest;

abstract class AttributeBaseRequest extends ApiRequest
{
    public function getEntity(): IAttribute
    {
        return $this->transform(IAttribute::class, $this->getModelStructure());
    }
}