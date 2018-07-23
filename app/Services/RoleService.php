<?php

namespace App\Services;

use App\Entities\Role;
use App\Repositories\RoleRepository;

class RoleService
{
    const ROLE_ADMIN = 'admin';

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
     * @param integer $id
     * @return Role
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param bool $withCriteria
     * @return mixed
     */
    public function paginate($withCriteria = false)
    {
        return $this->repository->paginateList($withCriteria);
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
     * @param array   $data
     * @param integer $id
     * @return Role
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
     * @param integer $id
     * @return integer
     */
    public function delete(int $id): int
    {
        $label = $this->repository->findModel($id);
        if (is_null($label)) {
            return 0;
        }

        return $this->repository->delete($id);
    }

    /**
     * @param Role  $role
     * @param array $permissionValues
     * @return void
     */
    private function savePermissionValues(Role $role, array $permissionValues): void
    {
        $this->repository->detachPermissions($role);

        foreach ($permissionValues as $permissionValue) {
            $this->attachPermission($role, $permissionValue);
        }
    }

    /**
     * @param Role  $role
     * @param array $permissionValue
     * @return void
     */
    private function attachPermission(Role $role, array $permissionValue): void
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

    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id)
    {
        return $this->repository->findModel($id);
    }
}
