<?php

use App\Entities\AccessType;
use App\Entities\Permission;
use App\Entities\PermissionGroup;
use App\Entities\Qualifier;
use App\Entities\Role;
use App\Entities\User;
use App\Services\PermissionService;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionService = app()->make(PermissionService::class);
        $permissionGroups = $permissionService->getPermissionsGroupsFromConfig();

        $permissionIds = [];
        foreach ($permissionGroups as $group) {
            $groupModel = PermissionGroup::whereName($group['machine_name'])->first();
            if (!$groupModel) {
                $groupModel = new PermissionGroup();
                $groupModel->name = $group['machine_name'];
                $groupModel->label = $group['label'];
                $groupModel->save();
            }

            foreach (array_get($group, 'qualifiers', []) as $qualifier) {
                $qualifierModel = Qualifier::whereName($qualifier['machine_name'])->first();
                if (!$qualifierModel) {
                    $qualifierModel = new Qualifier();
                    $qualifierModel->name = $qualifier['machine_name'];
                    $qualifierModel->label = $qualifier['label'];
                    $qualifierModel->permission_group_id = $groupModel->id;
                    $qualifierModel->save();
                }

                //create accessTypes
                foreach ($qualifier['access_types'] as $accessType) {
                    $accessTypeModel = AccessType::where('id', $accessType['machine_name'])->first();
                    if (!$accessTypeModel) {
                        $accessTypeModel = new AccessType();
                        $accessTypeModel->id = $accessType['machine_name'];
                        $accessTypeModel->label = $accessType['label'];
                        $accessTypeModel->save();
                    }
                    $qualifierModel->accessTypes()->attach($accessTypeModel);
                }
            }

            foreach ($group['permissions'] as $permission) {
                $permissionModel = Permission::whereName($permission['machine_name'])->first();
                if (!$permissionModel) {
                    $permissionModel = new Permission();
                    $permissionModel->name = $permission['machine_name'];
                    $permissionModel->label = $permission['label'];
                    $permissionModel->permission_group_id = $groupModel->id;
                    $permissionModel->save();
                }
                foreach (config('permissions.default_sets') as $key => $set) {
                    if (array_key_exists($permission['machine_name'], $set)) {
                        $permissionIds[$key][$permissionModel->id] = ['access_type' => isset($set[$permission['machine_name']]['access_type']) ? $set[$permission['machine_name']]['access_type'] : null];
                    }
                }

                foreach ($permission['access_types'] as $accessType) {
                    $accessTypeModel = AccessType::where('id', $accessType['machine_name'])->first();
                    if (!$accessTypeModel) {
                        $accessTypeModel = new AccessType();
                        $accessTypeModel->id = $accessType['machine_name'];
                        $accessTypeModel->label = $accessType['label'];
                        $accessTypeModel->save();
                    }
                    $permissionModel->accessTypes()->attach($accessTypeModel);
                }
            }
        }

        foreach ($permissionIds as $key => $set) {
            $this->getRole($key)->permissions()->sync($set);
        }

        $user = User::first();
        $user->roles()->sync($this->getRole('admin', 'Admin')->id);
    }

    private function getRole($name)
    {
        $role = Role::whereName($name)->first();
        if (is_null($role)) {
            $role = new Role();
            $role->name = $name;
            $role->save();
        }

        return $role;
    }
}
