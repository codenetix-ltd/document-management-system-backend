<?php

namespace App\Handlers\Permissions;

use App\Context\BlankAuthorizeContext;
use App\Role;

class GenericPermissionHandler extends ABlankPermissionHandler
{
    private $permission;

    public function __construct($permission)
    {
        $this->permission = $permission;
    }

    public function getPermissionName(): string
    {
        return $this->permission;
    }

    public function handle(BlankAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        /** @var Role $role */
        foreach ($roles as $role) {
            if ($role->hasPermission($this->getPermissionName())) return true;
        }

        return false;
    }
}