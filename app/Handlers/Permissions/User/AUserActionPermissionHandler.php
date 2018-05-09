<?php

namespace App\Handlers\Permissions\User;

use App\Context\UserAuthorizeContext;
use App\Contracts\Models\IRole;

abstract class AUserActionPermissionHandler extends AUserPermissionHandler
{
    public function handle(UserAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        foreach ($roles as $role) {
            /** @var IRole $role */
            if ($role->hasPermission($this->getPermissionName(), $context->getSubjectUser()->id, 'user')) return true;
        }

        return false;
    }
}