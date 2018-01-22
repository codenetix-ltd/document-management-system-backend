<?php

namespace App\Handlers\Permissions\User;

class UserDeletePermissionHandler extends AUserActionPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_delete';
    }
}