<?php

namespace App\Contracts\Commands\Role;

use App\Contracts\Models\IRole;

interface IRoleCreateCommand
{
    /**
     * @return IRole
     */
    public function getResult() : IRole;
}