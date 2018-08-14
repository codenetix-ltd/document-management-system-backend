<?php

namespace App\Http\Requests;

use App\Criteria\EmptyQueryParamsObject;
use App\Criteria\IQueryParamsObject;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class DocumentVersionListRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return EmptyQueryParamsObject::makeFromRequest($this);
    }
}