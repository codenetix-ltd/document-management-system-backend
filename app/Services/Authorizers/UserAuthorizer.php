<?php

namespace App\Services\Authorizers;

use App\Context\UserAuthorizeContext;
use App\FactoryMethods\UserPermissionFactoryMethod;
use App\Handlers\Permissions\User\AUserPermissionHandler;
use App\PermissionGroup;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
