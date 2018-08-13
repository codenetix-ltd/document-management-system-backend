<?php

namespace App\Entities;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class QualifierRolePermission extends Pivot implements Transformable
{
    use TransformableTrait;

    protected $table = 'qualifier_role_permission';
    public $enforceCamelCase = false;

    public function accessType()
    {
        return $this->hasOne(AccessType::class, 'id', 'access_type');
    }
}
