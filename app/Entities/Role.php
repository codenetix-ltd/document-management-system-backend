<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Role.
 *
 * @property string $name
 *
 * @property Collection | Template[] $templates
 * @property Collection | Permission[] $permissions
 * @property Collection | User[] $users
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Role extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name'];
    public $enforceCamelCase = false;
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "role_permission")->using(RolePermission::class)->withPivot(['id', 'entity_id', 'entity_type', 'access_type']);
    }

    public function templates()
    {
        return $this->belongsToMany(Template::class, "role_template");
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function hasPermission(string $permissionName, int $targetId = null, string $targetType = null) : bool
    {
        $query = $this->permissions()->where('name', $permissionName);
        if (!is_null($targetId)) {
            $query->where('role_permission.entity_id', $targetId);
        }
        if (!is_null($targetType)) {
            $query->where('role_permission.entity_type', $targetType);
        }

        return $query->exists();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }
}
