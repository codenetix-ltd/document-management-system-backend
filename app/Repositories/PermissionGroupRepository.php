<?php

namespace App\Repositories;

use App\Entities\PermissionGroup;
use Illuminate\Support\Collection;

/**
 * Class PermissionGroupRepository
 * @package App\Repositories
 */
class PermissionGroupRepository extends BaseRepository
{

    /**
     * @param string $permissionGroupName
     * @return Collection
     */
    public function getPermissionsName(string $permissionGroupName): Collection
    {
        $permissionGroup = $this->getInstance()->where('name', '=', $permissionGroupName)->first();

        return $permissionGroup->permissions->pluck('name');
    }

    /**
     * @return mixed
     */
    protected function getInstance()
    {
        return new PermissionGroup;
    }
}
