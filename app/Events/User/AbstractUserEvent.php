<?php

namespace App\Events\User;

use App\Events\Event;
use App\User;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractUserEvent extends Event
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
