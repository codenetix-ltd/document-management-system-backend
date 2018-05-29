<?php

namespace App\Services;

use App\Entities\Role;
use App\Repositories\RoleRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class RoleService
{
    /**
     * @var RoleRepository
     */
    protected $repository;

    /**
     * RoleService constructor.
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->repository->all();
    }

    /**
     * @param int $id
     * @return Role
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }

    /**
     * @param array $data
     * @return Role
     */
    public function create(array $data)
    {
        $role = $this->repository->create($data);

        if (!empty($data['templateIds'])) {
            $this->repository->sync($role->id, 'templates', $data['templateIds']);
        }

        if (!empty($data['permissionValues'])) {
            $this->savePermissionValues($role, $data['permissionValues']);
        }

        return $role;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $role = $this->repository->update($data, $id);

        if (!empty($data['templateIds'])) {
            $this->repository->sync($role->id, 'templates', $data['templateIds']);
        }

        if (!empty($data['permissionValues'])) {
            $this->savePermissionValues($role, $data['permissionValues']);
        }

        return $role;
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $label = $this->repository->findWhere([['id', '=', $id]])->first();
        if (is_null($label)) {
            return;
        }

        $this->repository->delete($id);
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
            'roleId' => $role->id,
            'permissionId' => $permissionValue['id'],
            'accessType' => $permissionValue['accessTypeId']
        ]);

        if ($permissionValue['accessTypeId'] == AccessTypeService::TYPE_BY_QUALIFIERS && !empty($permissionValue['qualifiers'])) {
            foreach ($permissionValue['qualifiers'] as $qualifier) {
                $this->repository->attachQualifierToRolePermission($rolePermission, [
                    $qualifier['id'] => ['accessType' => $qualifier['accessTypeId']]
                ]);
            }
        }
    }
}
