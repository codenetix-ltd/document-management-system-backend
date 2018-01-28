<?php

namespace App;

use App\Contracts\Models\IUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements IUser
{
    use Notifiable, HasApiTokens;

    private $templates_ids;

    protected $fillable = [
        'full_name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token', 'avatar_file_id'
    ];

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

    public function logs()
    {
        return $this->morphMany(Log::class, 'reference');
    }

    public function setId(int $id): IUser
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setFullName(string $fullName): IUser
    {
        $this->full_name = $fullName;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function setEmail(string $email): IUser
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): IUser
    {
        $this->password = $password;

        return $this;
    }

    public function setCreated(string $created): IUser
    {
        $this->setCreatedAt($created);

        return $this;
    }

    public function getCreated(): string
    {
        return $this->created_at;
    }

    public function setUpdated(string $updated): IUser
    {
        $this->setUpdatedAt($updated);

        return $this;
    }

    public function getUpdated(): string
    {
        return $this->updated_at;
    }

    public function setTemplatesIds(array $ids): IUser
    {
        $this->templates_ids = $ids;

        return $this;
    }

    public function getTemplatesIds(): ?array
    {
        return $this->templates_ids;
    }
}
