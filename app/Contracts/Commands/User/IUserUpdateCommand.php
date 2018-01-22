<?php

namespace App\Contracts\Commands\User;

use App\Contracts\Models\IUser;

interface IUserUpdateCommand
{
    /**
     * @return IUser
     */
    public function getResult();
}