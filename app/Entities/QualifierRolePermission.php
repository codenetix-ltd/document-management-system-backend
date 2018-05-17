<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class QualifierRolePermission extends Pivot
{
    protected $table = 'qualifier_role_permission';

    public function accessType()
    {
        return $this->hasOne(AccessType::class, 'id', 'access_type');
    }
}
