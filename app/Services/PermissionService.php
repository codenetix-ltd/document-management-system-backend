<?php

namespace App\Services;

use App\Entities\Permission;
use Illuminate\Support\Collection;

class PermissionService
{
    /**
     * @return array
     */
    public function getPermissionsGroupsFromConfig()
    {
        return config('permissions.groups');
    }

    /**
     * @return Collection
     */
    public function getAccessTypesByPermissionId()
    {
        $permissions = Permission::get();
        $config = $this->getPermissionsGroupsFromConfig();
        $result = new Collection();
        foreach ($permissions as $permission) {
            $permissionConfig = $config[$permission->permissionGroup->name]['permissions'][$permission->name];
            $result->put($permission->id, empty($permissionConfig['access_types']) ? new Collection([]) : new Collection($permissionConfig['access_types']));
        }
        return $result;
    }
}
