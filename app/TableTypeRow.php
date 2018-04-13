<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableTypeRow extends Model
{
    public $timestamps = false;

    public function setParentAttributeId(int $parentAttributeId): self
    {
        $this->parent_attribute_id = $parentAttributeId;

        return $this;
    }

    public function getParentAttributeId(): int
    {
        return $this->parent_attribute_id;
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

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
