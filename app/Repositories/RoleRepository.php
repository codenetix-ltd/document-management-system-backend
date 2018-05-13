<?php

namespace App\Repositories;

use App\Contracts\Repositories\IRoleRepository;
use App\Role;
use App\RolePermission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleRepository implements IRoleRepository
{
    public function create(Role $role): Role
    {
        $role->save();
        $role = Role::findOrFail($role->getId());

        return $role;
    }

    public function findOrFail(int $id): Role
    {
        return Role::findOrFail($id);
    }

    public function update(int $id, Role $requestRole): Role
    {
        //TODO - change logic for update
        $role = Role::findOrFail($id);
        $role->name = $requestRole->name;

        $role->save();

        return $role;
    }

    public function delete(int $id): ?bool
    {
        return Role::where('id', $id)->delete();
    }

    public function list(): LengthAwarePaginator
    {
        return Role::paginate();
    }

    public function syncTemplates(Role $model, array $templateIds): array
    {
        return $model->templates()->sync($templateIds);
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