<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    protected $table = 'role_permission';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entity()
    {
        return $this->morphTo();
    }

    public function qualifiers()
    {
        return $this->belongsToMany(Qualifier::class, 'qualifier_role_permission', 'role_permission_id', 'qualifier_id')->using(QualifierRolePermission::class)->withPivot(['id', 'qualifier_id', 'role_permission_id', 'access_type']);
    }

    public function accessType()
    {
        return $this->hasOne(AccessType::class, 'id', 'access_type');
    }

    public function getCreatedAtColumn()
    {
        return 'created_at';
    }

    public function getUpdatedAtColumn()
    {
        return 'updated_at';
    }
}
