<?php

namespace App\Contracts\Commands\Role;

use App\Contracts\Models\IRole;

interface IRoleGetCommand
{
    /**
     * @return IRole
     */
    public function getResult() : IRole;
}