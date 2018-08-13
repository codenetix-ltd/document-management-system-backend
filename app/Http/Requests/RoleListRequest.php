<?php

namespace App\Http\Requests;

use App\Criteria\EmptyQueryParamsObject;
use App\Criteria\IQueryParamsObject;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class RoleListRequest extends ABaseAPIRequest
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