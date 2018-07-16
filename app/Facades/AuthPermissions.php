<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AuthPermissions extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AuthPermissions';
    }
}
