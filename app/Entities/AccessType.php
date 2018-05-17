<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AccessType extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_access_types');
    }
}
