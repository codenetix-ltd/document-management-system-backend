<?php

namespace App\Contracts\Commands\Role;

use App\Contracts\Models\IRole;

interface IRoleUpdateCommand
{
    public function getResult() : IRole
    ;
}