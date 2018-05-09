<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

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
        if (!is_null($targetId)) $query->where('role_permission.entity_id', $targetId);
        if (!is_null($targetType)) $query->where('role_permission.entity_type', $targetType);

        return $query->exists();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        // TODO: Implement setId() method.
    }
}
