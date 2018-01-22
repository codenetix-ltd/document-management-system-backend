<?php

namespace App\Handlers\Permissions\User;

class UserViewPermissionHandler extends AUserActionPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_view';
    }
}