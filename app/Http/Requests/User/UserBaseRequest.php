<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;
use App\User;

abstract class UserBaseRequest extends ApiRequest
{
    public function getEntity(): User
    {
        return $this->transform(User::class);
    }
}