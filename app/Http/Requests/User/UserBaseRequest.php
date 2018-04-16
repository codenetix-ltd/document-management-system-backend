<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;
use App\User;

abstract class UserBaseRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getEntity(): User
    {
        return $this->transform(User::class);
    }
}