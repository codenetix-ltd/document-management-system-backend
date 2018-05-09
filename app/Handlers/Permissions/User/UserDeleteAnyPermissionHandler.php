<?php

namespace App\Handlers\Permissions\User;

class UserDeleteAnyPermissionHandler extends AUserActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_delete_any';
    }
}