<?php

namespace App;

use App\Contracts\Models\ITag;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model implements ITag
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
