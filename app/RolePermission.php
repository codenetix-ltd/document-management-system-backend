<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    public $timestamps = false;

    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entity()
    {
        return $this->morphTo();
    }

    public function qualifiers(){
        return $this->belongsToMany(Qualifier::class, 'qualifier_role_permission', 'role_permission_id', 'qualifier_id')->withPivot(['id', 'qualifier_id', 'role_permission_id', 'access_type']);
    }
}