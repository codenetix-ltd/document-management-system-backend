<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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
class Type extends BaseModel implements Transformable
{
    use TransformableTrait;
    public $enforceCamelCase = false;
    protected $fillable = ['name'];
}
