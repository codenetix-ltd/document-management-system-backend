<?php

namespace App\Context;

use App\Contracts\Entity\IHasUser;
use App\Entities\User;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class AAuthorizeContext implements IHasUser
{
    /**
     * @var User
     */
    protected $user;

    /**
     * AAuthorizeContext constructor.
     * @param Authenticatable $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
