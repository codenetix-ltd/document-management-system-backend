<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class QualifierRolePermission extends Pivot implements Transformable
{
    use TransformableTrait;

    protected $table = 'qualifier_role_permission';

    public function accessType()
    {
        return $this->hasOne(AccessType::class, 'id', 'access_type');
    }
}
