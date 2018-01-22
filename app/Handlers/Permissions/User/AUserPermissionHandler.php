<?php

namespace App\Handlers\Permissions\User;

use App\Context\UserAuthorizeContext;

abstract class AUserPermissionHandler
{
    abstract public function handle(UserAuthorizeContext $context) : bool;

    abstract public function getPermissionName() : string;
}