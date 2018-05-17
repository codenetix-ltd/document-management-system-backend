<?php

namespace App\Services;

use App\Permission;
use App\PermissionGroup;
use Illuminate\Support\Collection;

class PermissionService
{
    public function getPermissionsGroupsFromConfig()
    {
        return config('permissions.groups');
    }

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

//    public function getAccessTypesByPermissionId($permissionId)
//    {
//        $permission = Permission::find($permissionId);
//        $config = $this->getPermissionsGroupsFromConfig();
//
//        $permissionConfig = $config[$permission->permissionGroup->name]['permissions'][$permission->name];
//
//        return empty($permissionConfig['access_types']) ? new Collection([]) : new Collection($permissionConfig['access_types']);
//    }
}