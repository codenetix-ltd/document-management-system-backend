<?php

namespace App;

use App\Contracts\Models\ITag;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model implements ITag
{
    public function setId(int $id): ITag
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): ITag
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
