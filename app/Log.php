<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function reference()
    {
        return $this->morphTo()->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
