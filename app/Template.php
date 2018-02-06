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

    //TODO - подумать можно ли вынести типовые геттеры и сеттеры в трэит
    public function setId(int $id): ITemplate
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
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


    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
