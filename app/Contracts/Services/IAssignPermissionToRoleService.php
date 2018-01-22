<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface IAssignPermissionToRoleService
{
    public function getResult() : Collection;
}