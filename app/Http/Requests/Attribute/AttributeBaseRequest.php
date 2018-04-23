<?php

namespace App\Http\Requests\Attribute;

use App\Attribute;
use App\Http\Requests\ApiRequest;

abstract class AttributeBaseRequest extends ApiRequest
{
    protected $modelConfigName = 'AttributeRequest';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getEntity(): Attribute
    {
        return $this->transform(Attribute::class);
    }
}