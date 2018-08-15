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
    /**
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return IQueryParamsObject
     */
    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return DocumentListQueryParamsObject::makeFromRequest($this);
    }
}
