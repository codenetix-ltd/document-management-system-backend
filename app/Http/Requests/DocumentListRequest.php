<?php

namespace App\Http\Requests;

use App\Criteria\DocumentListQueryParamsObject;
use App\Criteria\IQueryParamsObject;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class DocumentListRequest extends ABaseAPIRequest
{
    public function rules(): array
    {
        return [];
    }

    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return DocumentListQueryParamsObject::makeFromRequest($this);
    }
}