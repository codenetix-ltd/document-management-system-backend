<?php

namespace App\Http\Requests\Role;

use App\QueryParams\EmptyQueryParamsObject;
use App\QueryParams\IQueryParamsObject;
use App\Http\Requests\ABaseAPIRequest;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class RoleListRequest extends ABaseAPIRequest
{
    //@TODO fix this shit
    public function authorize()
    {
        return true;
    }

    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return EmptyQueryParamsObject::makeFromRequest($this);
    }
}