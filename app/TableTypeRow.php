<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableTypeRow extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_attribute_id'
    ];
}
