<?php

namespace App\Repositories;

use App\Entities\PermissionGroup;

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
}
