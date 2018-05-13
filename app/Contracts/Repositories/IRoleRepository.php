<?php

namespace App\Contracts\Repositories;

use App\Role;
use App\RolePermission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IRoleRepository extends IRepository
{
    public function create(Role $role) : Role;

    public function list(): LengthAwarePaginator;

    public function syncTemplates(Role $model, array $templateIds): array;

    public function detachPermissions(Role $model): int;

    public function createRolePermission(array $data): RolePermission;

    public function attachQualifierToRolePermission(RolePermission $rolePermission, array $data);

    public function findOrFail(int $id) : Role;

    public function update(int $id, Role $requestRole): Role;

    public function delete(int $id): ?bool;
}