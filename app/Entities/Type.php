<?php

namespace App\Entities;

use Carbon\Carbon;

/**
 * Class Type.
 *
 * @property string $name
 * @property string $machineName
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Type extends BaseModel
{
    public $enforceCamelCase = false;
    protected $fillable = ['name'];
}
