<?php

namespace App\Handlers\Permissions\User;

class UserViewAnyPermissionHandler extends AUserActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_view_any';
    }
}