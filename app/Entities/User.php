<?php

namespace App\Entities;

use App\File;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class User.
 *
 * @property int $id
 * @property string $email
 * @property string $fullName
 * @property File $avatar
 * @property Collection|Document[] $documents
 * @property Collection|Template[] $templates
 * @property Collection|Role[] $roles
 */
class User extends BaseEntity implements Transformable
{
    use TransformableTrait;

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
        $this->attributes['password'] = bcrypt($password);
    }
}
