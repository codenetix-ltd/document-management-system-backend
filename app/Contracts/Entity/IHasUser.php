<?php

namespace App\Contracts\Entity;

use App\Entities\User;

interface IHasUser
{
    /**
     * @return User
     */
    public function getUser() : User;

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user) : void;
}
