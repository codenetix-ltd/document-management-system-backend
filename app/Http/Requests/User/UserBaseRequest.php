<?php

namespace App\Http\Requests\User;

use App\Contracts\Models\IUser;
use App\Http\Requests\ApiRequest;

abstract class UserBaseRequest extends ApiRequest
{
    public abstract function getModelStructure(): array;

    public function getEntity(): IUser
    {
        return $this->transform(IUser::class, $this->getModelStructure());
    }
}