<?php

namespace App\Handlers\Permissions;

use App\Context\BlankAuthorizeContext;
use App\Contracts\Models\IRole;
use App\Handlers\Permissions\ABlankPermissionHandler;

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
        foreach ($roles as $role) {
            /** @var IRole $role */
            if ($role->hasPermission($this->getPermissionName())) return true;
        }

        return false;
    }
}