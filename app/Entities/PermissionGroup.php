<?php

namespace App\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PermissionGroup.
 */
class PermissionGroup extends BaseEntity implements Transformable
{
    use TransformableTrait;

    public $timestamps = false;

    protected $fillable = [];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function qualifiers()
    {
        return $this->hasMany(Qualifier::class);
    }
}
