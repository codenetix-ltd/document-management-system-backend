<?php

namespace App\Entities;

use App\Contracts\Entity\IHasTitle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 *
 * @property int $id
 * @property string $email
 * @property string $fullName
 * @property string $password
 * @property File $avatar
 * @property Collection|Document[] $documents
 * @property Collection|Template[] $templates
 * @property Collection|Role[] $roles
 */
class User extends Authenticatable implements Transformable, IHasTitle
{
    use TransformableTrait;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName', 'email', 'avatarFileId'
    ];

    protected $hidden = [
        'password'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function templates()
    {
        return $this->belongsToMany(Template::class, "user_template");
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'owner_id', 'id');
    }

    public function avatar()
    {
        return $this->hasOne(File::class, 'id', 'avatar_file_id');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(snake_case($key));
        }
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }

    public function toArray()
    {
        $data = parent::toArray();
        $result = [];
        foreach ($data as $key => $item) {
            $result[camel_case($key)] = $item;
        }

        return $result;
    }

    public function getTitle(): string
    {
        return $this->fullName;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            return $this->roles()->whereIn('name', $roles)->exists();
        } else {
            return $this->roles()->where('name', $roles)->exists();
        }
    }

    public function hasAnyPermission($permissions)
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                foreach ($this->roles as $role) {
                    if ($role->hasPermission($permission)) return true;
                }
            }
        } else {
            foreach ($this->roles as $role) {
                if ($role->hasPermission($permissions)) return true;
            }
        }

        return false;
    }
}
