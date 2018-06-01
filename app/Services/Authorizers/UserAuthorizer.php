<?php

namespace App\Services\Authorizers;

use App\Context\UserAuthorizeContext;
use App\FactoryMethods\AbstractPermissionFactoryMethod;
use App\FactoryMethods\UserPermissionFactoryMethod;

class UserAuthorizer extends AAuthorizer
{
    /**
     * UserAuthorizer constructor.
     * @param UserAuthorizeContext $userAuthorizeContext
     */
    public function __construct(UserAuthorizeContext $userAuthorizeContext)
    {
        $this->context = $userAuthorizeContext;
    }

    /**
     * @return UserPermissionFactoryMethod
     */
    protected function getPermissionFactoryMethod(): AbstractPermissionFactoryMethod
    {
        return new UserPermissionFactoryMethod($this->context);
    }
}
