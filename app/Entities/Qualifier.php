<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Qualifier
 * @package App\Entities
 *
 * @property int $id
 * @property string $name
 * @property string $label
 *
 * @property Collection|AccessType[] $accessTypes
 * @property PermissionGroup $permissionGroup
 */
class Qualifier extends BaseModel implements Transformable
{
    use TransformableTrait;
    public $enforceCamelCase = false;
    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    public function accessTypes()
    {
        return $this->belongsToMany(AccessType::class, 'access_types_qualifiers');
    }
}
