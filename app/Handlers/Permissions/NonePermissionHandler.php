<?php

namespace App\Handlers\Permissions;

class NonePermissionHandler
{
    public function handle(): bool
    {
        return false;
    }
}
