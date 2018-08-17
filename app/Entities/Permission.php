<?php

namespace App\Entities;

use Illuminate\Support\Collection;

/**
 * Class Permission
 * @package App\Entities
 *
 * @property string $name
 * @property string $label
 *
 * @property Collection|AccessType[] $accessTypes
 * @property Collection|Role[] $roles
 */
class Permission extends BaseModel
{

    public $timestamps = false;
    public $enforceCamelCase = false;
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission')->withPivot(['entity_id', 'entity_type']);
    }

    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    public function accessTypes()
    {
        return $this->belongsToMany(AccessType::class, 'permissions_access_types');
    }
}
