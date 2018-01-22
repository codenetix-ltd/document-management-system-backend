<?php

use App\Contracts\Services\IPermissionService;
use App\Permission;
use App\PermissionGroup;
use App\Qualifier;
use App\Role;
use App\User;
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
        $permissionService = app()->make(IPermissionService::class);
        $permissionGroups = $permissionService->getPermissionsGroupsFromConfig();

        $permissionIds = [];
        foreach ($permissionGroups as $group) {
            $groupModel = PermissionGroup::whereName($group['machine_name'])->first();
            if(!$groupModel){
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
            }

            foreach ($group['permissions'] as $permission) {
                $model = Permission::whereName($permission['machine_name'])->first();
                if (!$model) {
                    $model = new Permission();
                    $model->name = $permission['machine_name'];
                    $model->label = $permission['label'];
                    $model->save();
                }

                foreach (config('permissions.default_sets') as $key => $set){
                    if (array_key_exists($permission['machine_name'], $set)){
                        $permissionIds[$key][$model->id] = ['access_type' => isset($set[$permission['machine_name']]['access_type']) ? $set[$permission['machine_name']]['access_type'] : null];
                    }
                }
            }
        }

        foreach ($permissionIds as $key => $set){
           $this->getRole($key, ucfirst($key))->permissions()->sync($set);
        }

        $user = User::findOrFail(1);
        $user->roles()->sync($this->getRole('admin', 'Admin')->id);
    }

    private function getRole($name, $label)
    {
        $role = Role::whereName($name)->first();
        if (is_null($role)) {
            $role = new Role();
            $role->name = $name;
            $role->label = $label;
            $role->save();
        }

        return $role;
    }
}
