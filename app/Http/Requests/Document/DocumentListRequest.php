<?php

namespace App\Http\Requests\Document;

use App\QueryParams\DocumentListQueryParamsObject;
use App\QueryParams\IQueryParamsObject;
use App\Http\Requests\ABaseAPIRequest;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class DocumentListRequest extends ABaseAPIRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return DocumentListQueryParamsObject::makeFromRequest($this);
    }
}