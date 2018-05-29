<?php

namespace App\Handlers\Permissions;

use App\Context\BlankAuthorizeContext;

abstract class ABlankPermissionHandler
{
    abstract public function getPermissionName() : string;

    public function handle(BlankAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        foreach ($roles as $role) {
            if ($role->hasPermission($this->getPermissionName())) {
                return true;
            }
        }

        return false;
    }
}
