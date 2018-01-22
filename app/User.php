<?php

namespace App;

use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasOwnerId;
use App\Contracts\Models\IUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements IUser, IHasId, IHasOwnerId
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function templates()
    {
        return $this->belongsToMany(Template::class, "user_template");
    }

    public function factories()
    {
        return $this->belongsToMany(Factory::class, "user_factory");
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'owner_id', 'id');
    }

    public function avatar()
    {
        return $this->hasOne(File::class, 'id', 'avatar_file_id');
    }

    public function getAvatarURL(){
        if($this->avatar){
            return asset('storage/'.$this->avatar->path);
        } else {
            return asset('storage/profile-default.png');
        }
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'reference');
    }

    public function getName()
    {
        return $this->full_name;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id)
    {

    }

    public function getOwnerId() : int
    {
        return $this->id;
    }

    public function setOwnerId(int $user) : void
    {
        // TODO: Implement setOwnerId() method.
    }
}
