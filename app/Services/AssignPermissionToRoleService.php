<?php

namespace App\Services;

use App\Contracts\Services\IAssignPermissionToRoleService;
use App\Contracts\Services\IPermissionService;
use App\Permission;
use App\Role;
use Illuminate\Support\Collection;

class AssignPermissionToRoleService extends AService implements IAssignPermissionToRoleService
{
    private $roleId;

    private $inputData;

    private $permissions;

    public function __construct($roleId, $inputData, $container)
    {
        parent::__construct($container);
        $this->roleId = $roleId;
        $this->inputData = $inputData;
        $this->permissions = new Collection();
    }

    public function getResult() : Collection
    {
        return $this->permissions;
    }

    public function execute()
    {
        $permissionModel = Permission::whereName($this->inputData['permission'])->first();

        $role = Role::findOrFail($this->roleId);

//        if (!empty($this->inputData['target'])) {
//            foreach ($this->inputData['target'] as $targetId) {
//                $role->permissions()->syncWithoutDetaching([$permissionModel->id => ['targeted_id' => $targetId]]);
//            }
//        } else {
            $role->permissions()->syncWithoutDetaching([$permissionModel->id => ['level' => !empty($this->inputData['level']) ? $this->inputData['level'] : null]]);
//        }

        return $this->permissions = $role->permissions;
    }
}