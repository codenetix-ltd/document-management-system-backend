<?php

namespace App\Services;

use App\Contracts\Services\IAuthorizeService;
use Illuminate\Support\Collection;

class AuthorizeService implements IAuthorizeService
{
    public function authorize(string $action, int $targetedId, string $targetedType, string $relation): bool
    {
        // TODO: Implement authorize() method.
    }

    public function getAvailablePermissions(): Collection
    {
        // TODO: Implement getAvailablePermissions() method.
    }

    public function hasAnyPermission(Collection $permissions): bool
    {
        // TODO: Implement hasAnyPermission() method.
    }
}