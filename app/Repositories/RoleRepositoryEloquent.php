<?php

namespace App\Repositories;

use App\Entities\RolePermission;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
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
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function detachPermissions(Role $model): int
    {
        return $model->permissions()->detach();
    }

    public function createRolePermission(array $data): RolePermission
    {
        $rolePermission = new RolePermission($data);
        $rolePermission->save();
        $rolePermission = RolePermission::findOrFail($rolePermission->id);

        return $rolePermission;
    }

    public function attachQualifierToRolePermission(RolePermission $rolePermission, array $data)
    {
        $rolePermission->qualifiers()->attach($data);
    }
}