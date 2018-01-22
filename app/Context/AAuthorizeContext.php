<?php

namespace App\Context;

use App\Contracts\Entity\IHasUser;
use App\User;

abstract class AAuthorizeContext implements IHasUser
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}