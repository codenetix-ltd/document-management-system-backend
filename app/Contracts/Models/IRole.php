<?php

namespace App\Contracts\Models;

interface IRole
{
    public function hasPermission(string $permissionName, int $targetId = null, string $targetType = null) : bool;
}