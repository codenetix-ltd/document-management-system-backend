<?php

namespace App\FactoryMethods;

use App\Entities\Permission;
use App\Entities\Role;

abstract class AbstractPermissionFactoryMethod
{
    /**
     * @param Role       $role
     * @param Permission $permission
     * @param string     $handlerClass
     * @return mixed
     */
    abstract public function make(Role $role, Permission $permission, string $handlerClass);
}
