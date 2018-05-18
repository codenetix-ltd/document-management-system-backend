<?php

namespace App\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class QualifierRolePermission extends BasePivotEntity implements Transformable
{
    use TransformableTrait;

    protected $table = 'qualifier_role_permission';

    public function accessType()
    {
        return $this->hasOne(AccessType::class, 'id', 'access_type');
    }
}
