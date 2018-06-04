<?php

namespace App\Entities;

use App\Contracts\Entity\IHasTitle;
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
class Template extends BaseEntity implements Transformable, IHasTitle
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
    public function getTitle(): string
    {
        return $this->name;
    }
}
