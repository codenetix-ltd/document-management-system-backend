<?php

namespace App\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Type.
 */
class Type extends BaseEntity implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name', ];
}
