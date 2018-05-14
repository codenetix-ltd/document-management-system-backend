<?php

namespace App\Services;

use App\Contracts\Repositories\IRoleRepository;
use App\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class RoleService
{
    private $repository;

    public function __construct(IRoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Role $requestRole) : Role
    {
        $role = $this->repository->create($requestRole);
        if ($requestRole->getTemplatesIds()) {
            $this->repository->syncTemplates($role, $requestRole->getTemplatesIds());
        }

        if ($requestRole->getPermissionValues()) {
            $this->savePermissionValues($role, $requestRole->getPermissionValues());
        }

        return $role;
    }

    private function savePermissionValues(Role $role, array $permissionValues)
    {
        $this->repository->detachPermissions($role);

        foreach ($permissionValues as $permissionValue) {
            $this->attachPermission($role, $permissionValue);
        }
    }

    private function attachPermission(Role $role, array $permissionValue)
    {
        $rolePermission = $this->repository->createRolePermission([
            'role_id' => $role->id,
            'permission_id' => $permissionValue['id'],
            'access_type' => $permissionValue['accessTypeId']
        ]);

        if ($permissionValue['accessTypeId'] == AccessTypeService::TYPE_BY_QUALIFIERS && !empty($permissionValue['qualifiers'])) {
            foreach ($permissionValue['qualifiers'] as $qualifier) {
                $this->repository->attachQualifierToRolePermission($rolePermission, [
                    $qualifier['id'] => ['access_type' => $qualifier['accessTypeId']]
                ]);
            }
        }
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
    }

    public function get(int $id): Role
    {
        return $this->repository->findOrFail($id);
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }

    public function update(int $id, Role $requestRole): Role
    {
        $role = $this->repository->update($id, $requestRole);

        if ($requestRole->getTemplatesIds()) {
            $this->repository->syncTemplates($role, $requestRole->getTemplatesIds());
        }

        if ($requestRole->getPermissionValues()) {
            $this->savePermissionValues($role, $requestRole->getPermissionValues());
        }

        return $role;
    }
}
