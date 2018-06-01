<?php

namespace App\FactoryMethods;

use App\Context\UserAuthorizeContext;
use App\Entities\Permission;
use App\Entities\Role;
use App\Handlers\Permissions\AnyPermissionHandler;
use App\Handlers\Permissions\ByOwnerPermissionHandler;
use App\Handlers\Permissions\NonePermissionHandler;
use RuntimeException;

class UserPermissionFactoryMethod extends AbstractPermissionFactoryMethod
{
    /**
     * @var UserAuthorizeContext
     */
    private $context;

    /**
     * UserPermissionFactoryMethod constructor.
     * @param UserAuthorizeContext $context
     */
    public function __construct(UserAuthorizeContext $context)
    {
        $this->context = $context;
    }

    /**
     * @param Role       $role
     * @param Permission $permission
     * @param string     $handlerClass
     * @return AnyPermissionHandler|ByOwnerPermissionHandler|NonePermissionHandler|mixed
     */
    public function make(Role $role, Permission $permission, string $handlerClass)
    {
        switch ($handlerClass) {
            case AnyPermissionHandler::class:
                return new AnyPermissionHandler();
            case NonePermissionHandler::class:
                return new NonePermissionHandler();
            case ByOwnerPermissionHandler::class:
                return new ByOwnerPermissionHandler($this->context->getUser(), $this->context->getSubjectUser());
            default:
                throw new RuntimeException("Unsupported handlerClass provided");
        }
    }
}
