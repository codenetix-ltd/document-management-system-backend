<?php

namespace App\Services\Authorizers;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class AAuthorizer
{
    protected $context;

    public function authorize($permission)
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

        throw new AccessDeniedHttpException('You don\'t have enough rights to perform this operation');
    }

    abstract protected function getPermissionFactoryMethod();
}
