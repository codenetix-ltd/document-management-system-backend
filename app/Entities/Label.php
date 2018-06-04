<?php

namespace App\Entities;

use App\Contracts\Entity\IHasTitle;
use Carbon\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Label.
 *
 * @property int $id
 * @property string $name
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Label extends BaseEntity implements Transformable, IHasTitle
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function getTitle(): string
    {
        return $this->name;
    }
}
