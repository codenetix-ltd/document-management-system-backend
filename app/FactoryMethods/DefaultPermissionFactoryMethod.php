<?php

namespace App\FactoryMethods;

use App\Entities\Permission;
use App\Entities\Role;
use App\Handlers\Permissions\AnyPermissionHandler;
use App\Handlers\Permissions\NonePermissionHandler;

class DefaultPermissionFactoryMethod extends AbstractPermissionFactoryMethod
{
    /**
     * @param Role       $role
     * @param Permission $permission
     * @param string     $handlerClass
     * @return AnyPermissionHandler|NonePermissionHandler
     */
    public function make(Role $role, Permission $permission, string $handlerClass)
    {
        switch ($handlerClass) {
            case AnyPermissionHandler::class:
                return new AnyPermissionHandler();
            case NonePermissionHandler::class:
                return new NonePermissionHandler();
            default:
                dump($handlerClass);
                exit();
        }
    }
}
