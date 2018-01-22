<?php

namespace App\Contracts\Commands\User;

use App\Contracts\Models\IUser;

interface IUserSetAvatarCommand
{
    /**
     * @return IUser
     */
    public function getResult();
}