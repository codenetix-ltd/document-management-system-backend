<?php

namespace App;

use App\Contracts\Models\IType;
use Illuminate\Database\Eloquent\Model;

class Type extends Model implements IType
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
