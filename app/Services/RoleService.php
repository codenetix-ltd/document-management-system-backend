<?php

namespace App\Services;

use App\QueryParams\IQueryParamsObject;
use App\Entities\Role;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param IQueryParamsObject $queryParamsObject
     * @return mixed
     */
    public function paginate(IQueryParamsObject $queryParamsObject)
    {
        return $this->repository->paginateList($queryParamsObject);
    }

    /**
     * @param array $data
     * @return Role
     */
    public function create(array $data)
    {
        $role = $this->repository->create($data);

        $this->repository->sync($role->id, 'templates', array_get($data, 'templatesIds'));

        $this->savePermissionValues($role, array_get($data, 'permissionValues'));

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

        $this->repository->sync($role->id, 'templates', array_get($data, 'templatesIds'));

        $this->savePermissionValues($role, array_get($data, 'permissionValues'));

        return $role;
    }

    /**
     * @param integer $id
     * @return integer
     */
    public function delete(int $id): ?int
    {
        try {
            $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return null;
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
        /**
         * @TODO: fix cases
         */
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
}
