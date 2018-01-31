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

    public function setCreated(string $created): ITag
    {
        $this->setCreatedAt($created);

        return $this;
    }

    public function getCreated(): string
    {
        return $this->created_at;
    }

    public function setUpdated(string $updated): ITag
    {
        $this->setUpdatedAt($updated);

        return $this;
    }

    public function getUpdated(): string
    {
        return $this->updated_at;
    }
}
