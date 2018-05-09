<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

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
