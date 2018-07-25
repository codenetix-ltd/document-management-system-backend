<?php

namespace App\Repositories;

use App\Entities\Role;
use App\Entities\RolePermission;

/**
 * Interface RoleRepository.
 */
interface RoleRepository extends RepositoryInterface
{
    /**
     * @param Role $model
     * @return integer
     */
    public function detachPermissions(Role $model): int;

    /**
     * @param array $data
     * @return RolePermission
     */
    public function createRolePermission(array $data): RolePermission;

    /**
     * @param RolePermission $rolePermission
     * @param array          $data
     * @return void
     */
    public function attachQualifierToRolePermission(RolePermission $rolePermission, array $data): void;

    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id);
}
