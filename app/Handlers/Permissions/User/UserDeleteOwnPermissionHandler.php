<?php

namespace App\Handlers\Permissions\User;

class UserDeleteOwnPermissionHandler extends AUserActionOwnPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_delete_own';
    }
}