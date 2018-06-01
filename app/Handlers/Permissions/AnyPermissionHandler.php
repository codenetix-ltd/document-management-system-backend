<?php

namespace App\Handlers\Permissions;

class AnyPermissionHandler
{
    /**
     * @return boolean
     */
    public function handle(): bool
    {
        return true;
    }
}
