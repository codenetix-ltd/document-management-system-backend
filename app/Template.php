<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class)->orderBy('order', 'ASC')->whereNull('parent_attribute_id');
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
