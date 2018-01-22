<?php

namespace App\Handlers\Permissions\User;

class UserUpdateAnyPermissionHandler extends AUserActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_update_any';
    }
}