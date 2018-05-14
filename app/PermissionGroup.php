<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'label', 'machine_name'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function qualifiers()
    {
        return $this->hasMany(Qualifier::class);
    }
}
