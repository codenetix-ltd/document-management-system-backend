<?php

namespace App\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AccessType extends BaseEntity implements Transformable
{
    use TransformableTrait;

    protected $primaryKey = 'id';
    public $incrementing = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_access_types');
    }
}
