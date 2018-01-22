<?php

namespace App\Contracts\Commands\User;

use App\Contracts\Models\IUser;

interface IUserGetCommand
{
    /**
     * @return IUser
     */
    public function getResult();
}