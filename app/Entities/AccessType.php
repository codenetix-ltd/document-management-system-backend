<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AccessType extends Model implements Transformable
{
    use TransformableTrait;

    protected $primaryKey = 'id';
    public $incrementing = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_access_types');
    }
}
