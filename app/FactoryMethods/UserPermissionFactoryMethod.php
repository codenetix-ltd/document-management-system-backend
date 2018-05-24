<?php

namespace App\FactoryMethods;

use App\Context\UserAuthorizeContext;
use App\Entities\Permission;
use App\Entities\Role;
use App\Handlers\Permissions\AnyPermissionHandler;
use App\Handlers\Permissions\ByOwnerPermissionHandler;
use App\Handlers\Permissions\NonePermissionHandler;
use RuntimeException;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class UserPermissionFactoryMethod
{
    private $context;

    public function __construct(UserAuthorizeContext $context)
    {
        $this->context = $context;
    }

    public function make(Role $role, Permission $permission, $handlerClass){
        switch($handlerClass){
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