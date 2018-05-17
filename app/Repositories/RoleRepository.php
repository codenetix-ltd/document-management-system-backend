<?php

namespace App\Repositories;

use App\Entities\Role;
use App\Entities\RolePermission;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RoleRepository.
 */
interface RoleRepository extends RepositoryInterface
{
    public function detachPermissions(Role $model): int;

    public function createRolePermission(array $data): RolePermission;

    public function attachQualifierToRolePermission(RolePermission $rolePermission, array $data);
}
