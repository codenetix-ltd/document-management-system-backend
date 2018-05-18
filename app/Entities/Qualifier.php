<?php

namespace App\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Qualifier extends BaseEntity implements Transformable
{
    use TransformableTrait;

    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    public function accessTypes()
    {
        return $this->belongsToMany(AccessType::class, 'access_types_qualifiers');
    }
}
