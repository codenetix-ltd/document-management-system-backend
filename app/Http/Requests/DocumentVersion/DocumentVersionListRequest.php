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

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return IQueryParamsObject
     */
    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return EmptyQueryParamsObject::makeFromRequest($this);
    }
}
