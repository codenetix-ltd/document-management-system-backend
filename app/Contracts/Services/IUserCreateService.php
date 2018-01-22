<?php

namespace App\Contracts\Services;

use App\Contracts\Models\IUser;

interface IUserCreateService
{
    /**
     * @return IUser
     */
    public function getResult();
}