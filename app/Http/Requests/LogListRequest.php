<?php

namespace App\Http\Requests;

use App\Criteria\LogListQueryParamsObject;
use App\Criteria\IQueryParamsObject;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class LogListRequest extends ABaseAPIRequest
{
    public function rules(): array
    {
        return [];
    }

    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return LogListQueryParamsObject::makeFromRequest($this);
    }
}