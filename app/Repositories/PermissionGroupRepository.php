<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

/**
 * Interface PermissionGroupRepository.
 */
interface PermissionGroupRepository extends RepositoryInterface
{
    /**
     * @param string $permissionGroupName
     * @return Collection
     */
    public function getPermissionsName(string $permissionGroupName): Collection;
}
