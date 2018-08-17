<?php

namespace App\Entities;

use Carbon\Carbon;

/**
 * Class AccessType
 * @package App\Entities
 *
 * @property string $label
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class AccessType extends BaseModel
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $enforceCamelCase = false;


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_access_types');
    }
}
