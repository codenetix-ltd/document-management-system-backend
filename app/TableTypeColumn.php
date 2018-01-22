<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableTypeColumn extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type_id', 'parent_attribute_id'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
