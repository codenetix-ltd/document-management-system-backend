<?php

namespace App\Contracts\Services;

use App\Contracts\Models\IUser;

interface IUserUpdateService
{
    /**
     * @return IUser
     */
    public function getResult();
}