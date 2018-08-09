<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PermissionGroup.
 *
 * @property Collection|Permission[] $permissions
 * @property Collection|Qualifier[] $qualifiers
 */
class PermissionGroup extends BaseModel implements Transformable
{
    use TransformableTrait;

    public $timestamps = false;

    protected $fillable = [];
    public $enforceCamelCase = false;
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function qualifiers()
    {
        return $this->hasMany(Qualifier::class);
    }
}
