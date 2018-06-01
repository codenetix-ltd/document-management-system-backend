<?php

namespace App\Context;

use App\Entities\User;

class BlankAuthorizeContext extends AAuthorizeContext
{
    /**
     * BlankAuthorizeContext constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
