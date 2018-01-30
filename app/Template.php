<?php

namespace App;

use App\Contracts\Models\ITemplate;
use Illuminate\Database\Eloquent\Model;

class Template extends Model implements ITemplate
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

    public function setName(string $name): ITemplate
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCreated(string $created): ITemplate
    {
        $this->setCreatedAt($created);

        return $this;
    }

    public function getCreated(): string
    {
        return $this->created_at;
    }

    public function setUpdated(string $updated): ITemplate
    {
        $this->setUpdatedAt($updated);

        return $this;
    }

    public function getUpdated(): string
    {
        return $this->updated_at;
    }
}
