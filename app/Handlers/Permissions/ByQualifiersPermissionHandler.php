<?php

namespace App\Handlers\Permissions;

use App\Context\AAuthorizeContext;
use App\Entities\Permission;
use App\Entities\Role;
use App\FactoryMethods\AbstractPermissionFactoryMethod;

class ByQualifiersPermissionHandler
{
    /**
     * @var AbstractPermissionFactoryMethod
     */
    private $factoryMethod;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @var AAuthorizeContext
     */
    private $context;

    /**
     * @var Role
     */
    private $role;

    /**
     * ByQualifiersPermissionHandler constructor.
     * @param AAuthorizeContext               $context
     * @param Role                            $role
     * @param AbstractPermissionFactoryMethod $factoryMethod
     * @param Permission                      $permission
     */
    public function __construct(AAuthorizeContext $context, Role $role, AbstractPermissionFactoryMethod $factoryMethod, Permission $permission)
    {
        $this->permission = $permission;
        $this->context = $context;
        $this->factoryMethod = $factoryMethod;
        $this->role = $role;
    }

    /**
     * @return boolean
     */
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
