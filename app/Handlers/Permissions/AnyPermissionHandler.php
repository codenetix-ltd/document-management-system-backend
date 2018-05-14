<?php

namespace App\Handlers\Permissions;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AnyPermissionHandler
{
    public function handle(): bool
    {
        return true;
    }
}