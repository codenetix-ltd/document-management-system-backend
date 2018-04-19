<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    private $templates_ids;

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

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setFullName(string $fullName): self
    {
        $this->full_name = $fullName;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setTemplatesIds(array $ids): self
    {
        $this->templates_ids = $ids;

        return $this;
    }

    public function getTemplatesIds(): ?array
    {
        return $this->templates_ids;
    }

    public function getAvatar(): File
    {
        return $this->avatar;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function getAvatarId(): ?int
    {
        return $this->avatar_file_id;
    }

    public function setAvatarId(int $avatarId)
    {
        $this->avatar_file_id = $avatarId;
    }
}
