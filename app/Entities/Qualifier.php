<?php

namespace App\Entities;

use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Qualifier
 * @package App\Entities
 *
 * @property string $name
 * @property string $label
 *
 * @property Collection|AccessType[] $accessTypes
 * @property PermissionGroup $permissionGroup
 */
class Qualifier extends BaseEntity implements Transformable
{
    use TransformableTrait;

    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    public function accessTypes()
    {
        return $this->belongsToMany(AccessType::class, 'access_types_qualifiers');
    }
}
