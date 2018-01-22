<?php

namespace App\Context;

use App\User;

class BlankAuthorizeContext extends AAuthorizeContext
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
