<?php

namespace App\Handlers\Permissions;

class NonePermissionHandler
{
    /**
     * @return boolean
     */
    public function handle(): bool
    {
        return false;
    }
}
