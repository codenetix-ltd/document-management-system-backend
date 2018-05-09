<?php

namespace App\Handlers\Permissions\User;

class UserUpdatePermissionHandler extends AUserActionPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_update';
    }
}