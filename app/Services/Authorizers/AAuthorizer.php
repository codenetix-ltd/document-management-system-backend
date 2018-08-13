<?php

namespace App\Services\Authorizers;

use App\Context\AAuthorizeContext;
use App\FactoryMethods\AbstractPermissionFactoryMethod;

abstract class AAuthorizer
{
    /**
     * @var AAuthorizeContext
     */
    protected $context;

    /**
     * @param string $permission
     * @return boolean
     */
    public function check(string $permission)
    {
        $user = $this->context->getUser();

        foreach ($user->roles as $role) {
            $permissionModel = $role->permissions()->where('name', $permission)->first();
            if (!$permissionModel) {
                continue;
            }

            $group = $permissionModel->permissionGroup;
            $handlerClass = config('permissions.groups.'.$group->name.'.permissions.'.$permission.'.access_types.'.$permissionModel->pivot->access_type.'.handler');
            $handlerInstance = $this->getPermissionFactoryMethod()->make($role, $permissionModel, $handlerClass);

            if ($handlerInstance->handle()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return AbstractPermissionFactoryMethod
     */
    abstract protected function getPermissionFactoryMethod(): AbstractPermissionFactoryMethod;
}
