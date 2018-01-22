<?php

namespace App\Contracts\Entity;

use App\User;

interface IHasUser
{
    public function getUser() : User;
    public function setUser(User $user) : void;
}
