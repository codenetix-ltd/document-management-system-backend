<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualifier extends Model
{
    public $timestamps = false;

    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }
}
