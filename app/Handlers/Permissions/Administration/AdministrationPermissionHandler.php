<?php

namespace App\Handlers\Permissions\Administration;

use App\Context\BlankAuthorizeContext;
use App\Contracts\Models\IRole;
use App\Handlers\Permissions\ABlankPermissionHandler;

class AdministrationPermissionHandler extends ABlankPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'administration';
    }

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