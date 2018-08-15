<?php

namespace App\Http\Requests\User;

use App\QueryParams\EmptyQueryParamsObject;
use App\QueryParams\IQueryParamsObject;
use App\Http\Requests\ABaseAPIRequest;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class UserListRequest extends ABaseAPIRequest
{

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
