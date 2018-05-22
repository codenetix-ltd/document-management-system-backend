<?php

namespace App\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Template.
 *
 * @property int id
 */
class Template extends BaseEntity implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

//    public function documents()
//    {
//        return $this->hasMany(Document::class);
//    }
//
//    public function attributes()
//    {
//        return $this->hasMany(Attribute::class)->orderBy('order', 'ASC')->whereNull('parent_attribute_id');
//    }
//
//    public function logs()
//    {
//        return $this->morphMany(Log::class, 'reference');
//    }
}
