<?php

namespace App\Handlers\Permissions\User;

class UserUpdateOwnPermissionHandler extends AUserActionOwnPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_update_own';
    }
}