<?php

namespace App\Handlers\Permissions;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class NonePermissionHandler
{
    public function handle(): bool
    {
        return false;
    }
}