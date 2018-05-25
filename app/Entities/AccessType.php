<?php

namespace App\Entities;

use Carbon\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AccessType
 * @package App\Entities
 *
 * @property string $label
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class AccessType extends BaseEntity implements Transformable
{
    use TransformableTrait;

    protected $primaryKey = 'id';
    public $incrementing = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_access_types');
    }
}
