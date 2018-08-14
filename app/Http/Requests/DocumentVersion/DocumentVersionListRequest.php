<?php

namespace App\Http\Requests\DocumentVersion;

use App\QueryParams\EmptyQueryParamsObject;
use App\QueryParams\IQueryParamsObject;
use App\Http\Requests\ABaseAPIRequest;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class DocumentVersionListRequest extends ABaseAPIRequest
{
    public function rules(): array
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return EmptyQueryParamsObject::makeFromRequest($this);
    }
}