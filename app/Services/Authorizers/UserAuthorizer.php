<?php

namespace App\Services\Authorizers;

use App\Context\UserAuthorizeContext;
use App\FactoryMethods\UserPermissionFactoryMethod;

class UserAuthorizer extends AAuthorizer
{
    public function __construct(UserAuthorizeContext $userAuthorizeContext)
    {
        $this->context = $userAuthorizeContext;
    }

    protected function getPermissionFactoryMethod()
    {
        return new UserPermissionFactoryMethod($this->context);
    }
}
