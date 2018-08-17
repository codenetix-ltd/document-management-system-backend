<?php

namespace App\Entities;

use Illuminate\Support\Collection;

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
class Qualifier extends BaseModel
{
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
