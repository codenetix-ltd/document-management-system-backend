<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualifier extends Model
{
    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    public function accessTypes()
    {
        return $this->belongsToMany(AccessType::class, 'access_types_qualifiers');
    }
}
