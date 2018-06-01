<?php

namespace App\Events\User;

use App\Events\Event;
use App\Entities\User;

abstract class AbstractUserEvent extends Event
{
    /**
     * @var User
     */
    private $user;

    /**
     * AbstractUserEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
