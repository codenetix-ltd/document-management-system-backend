<?php

namespace App\Entities;

use Carbon\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Type.
 *
 * @property string $name
 * @property string $machineName
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Type extends BaseEntity implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name', ];
}
