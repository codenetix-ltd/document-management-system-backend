<?php

namespace App\Handlers\Permissions\User;

use App\Context\UserAuthorizeContext;

abstract class AUserActionOwnPermissionHandler extends AUserPermissionHandler
{
    public function handle(UserAuthorizeContext $context): bool
    {
        if ($context->getUser()->id == $context->getSubjectUser()->id) {
            return true;
        }

        return false;
    }
}