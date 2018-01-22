<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface IAuthorizeService
{
    public function authorize(string $action, int $targetedId, string $targetedType, string $relation): bool;
    public function getAvailablePermissions(): Collection;
    public function hasAnyPermission(Collection $permissions): bool;
}