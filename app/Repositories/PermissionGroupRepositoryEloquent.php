<?php

namespace App\Repositories;

use App\Entities\PermissionGroup;
use Illuminate\Support\Collection;

/**
 * Class DocumentRepositoryEloquent.
 */
class PermissionGroupRepositoryEloquent extends BaseRepository implements PermissionGroupRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PermissionGroup::class;
    }

    /**
     * @param string $permissionGroupName
     * @return Collection
     */
    public function getPermissionsName(string $permissionGroupName): Collection
    {
        $permissionGroup = $this->findWhere([
            ['name', '=', $permissionGroupName]
        ])->first();

        return $permissionGroup->permissions->pluck('name');
    }
}
