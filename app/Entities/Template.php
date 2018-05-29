<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Template.
 *
 * @property string $name
 * @property Collection $attributes
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Templateextends BaseEntity implements Transformable
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
    public function attributes()
    {
        return $this->hasMany(Attribute::class)->orderBy('order', 'ASC')->whereNull('parent_attribute_id');
    }
//
//    public function logs()
//    {
//        return $this->morphMany(Log::class, 'reference');
//    }
}
