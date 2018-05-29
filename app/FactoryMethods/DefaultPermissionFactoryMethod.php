<?php namespace App\FactoryMethods;

use App\Entities\Permission;
use App\Entities\Role;
use App\Handlers\Permissions\AnyPermissionHandler;
use App\Handlers\Permissions\NonePermissionHandler;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DefaultPermissionFactoryMethod
{
    public function make(Role $role, Permission $permission, $handlerClass)
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
