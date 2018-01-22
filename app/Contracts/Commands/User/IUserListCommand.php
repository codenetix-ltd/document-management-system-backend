<?php

namespace App\Contracts\Commands\User;

use App\Contracts\Models\IUser;
use Illuminate\Database\Eloquent\Collection;

interface IUserListCommand
{
    /**
     * @return Collection|IUser
     */
    public function getResult();
}