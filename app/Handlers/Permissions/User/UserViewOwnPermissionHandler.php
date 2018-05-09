<?php

namespace App\Handlers\Permissions\User;

class UserViewOwnPermissionHandler extends AUserActionOwnPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_view_own';
    }
}