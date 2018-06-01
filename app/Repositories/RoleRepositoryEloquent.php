<?php

namespace App\Repositories;

use App\Entities\RolePermission;
use App\Entities\Role;

/**
 * Class DocumentRepositoryEloquent.
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * @param Role $model
     * @return integer
     */
    public function detachPermissions(Role $model): int
    {
        return $model->permissions()->detach();
    }

    /**
     * @param array $data
     * @return RolePermission
     */
    public function createRolePermission(array $data): RolePermission
    {
        $rolePermission = new RolePermission($data);
        $rolePermission->save();
        $rolePermission = RolePermission::findOrFail($rolePermission->id);

        return $rolePermission;
    }

    /**
     * @param RolePermission $rolePermission
     * @param array          $data
     * @return void
     */
    public function attachQualifierToRolePermission(RolePermission $rolePermission, array $data): void
    {
        $rolePermission->qualifiers()->attach($data);
    }
}
