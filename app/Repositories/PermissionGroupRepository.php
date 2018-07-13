<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

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
