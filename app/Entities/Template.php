<?php

namespace App\Entities;

use App\Contracts\Entity\IHasTitle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Template.
 *
 * @property string $name
 * @property Collection $attributes
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Template extends BaseModel implements IHasTitle
{
    public $enforceCamelCase = false;
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
