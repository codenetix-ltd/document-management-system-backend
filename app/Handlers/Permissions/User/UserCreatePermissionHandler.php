<?php

namespace App\Handlers\Permissions\User;

use App\Handlers\Permissions\ABlankPermissionHandler;

class UserCreatePermissionHandler extends ABlankPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'user_create';
    }
}