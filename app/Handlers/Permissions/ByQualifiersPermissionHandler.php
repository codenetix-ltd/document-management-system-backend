<?php

namespace App\Handlers\Permissions;

use App\Entities\Permission;

class ByQualifiersPermissionHandler
{
    private $factoryMethod;
    private $permission;
    private $context;
    private $role;

    public function __construct($context, $role, $factoryMethod, Permission $permission)
    {
        $this->permission = $permission;
        $this->context = $context;
        $this->factoryMethod = $factoryMethod;
        $this->role = $role;
    }

    public function handle(): bool
    {
        $qualifiers = $this->permission->pivot->qualifiers;

        foreach ($qualifiers as $qualifier) {
            $handlerClass = config('permissions.groups.' .
                $this->permission->permissionGroup->name . '.qualifiers.' .
                $qualifier->name . '.access_types.' .
                $qualifier->pivot->access_type . '.handler');

            $handlerInstance = $this->factoryMethod->make($this->role, $this->permission, $handlerClass);
            if (!$handlerInstance->handle()) {
                return false;
            }
        }

        return true;
    }
}
