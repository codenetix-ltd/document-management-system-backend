<?php

namespace App\Handlers\Permissions;

use App\Context\BlankAuthorizeContext;
use App\Contracts\Models\IRole;

abstract class ABlankPermissionHandler
{
    abstract public function getPermissionName() : string;

    public function handle(BlankAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        foreach ($roles as $role) {
            /** @var IRole $role */
            if ($role->hasPermission($this->getPermissionName())) return true;
        }

        return false;
    }
}