<?php

namespace App\Contracts\Entity;

use App\Entities\User;

interface IHasUser
{
    public function getUser() : User;
    public function setUser(User $user) : void;
}
