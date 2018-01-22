<?php

namespace App\Contracts\Commands\User;

use App\Contracts\Models\IUser;

interface IUserCreateCommand
{
    /**
     * @return IUser
     */
    public function getResult();
}