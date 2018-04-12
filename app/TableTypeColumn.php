<?php

namespace App;

use App\Contracts\Models\ITableTypeColumn;
use Illuminate\Database\Eloquent\Model;

class TableTypeColumn extends Model implements ITableTypeColumn
{
    public $timestamps = false;

    public function setParentAttributeId(int $parentAttributeId): ITableTypeColumn
    {
        $this->parent_attribute_id = $parentAttributeId;

        return $this;
    }

    public function getParentAttributeId(): int
    {
        return $this->parent_attribute_id;
    }

    public function setName(string $name): ITableTypeColumn
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setId(int $id): ITableTypeColumn
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
