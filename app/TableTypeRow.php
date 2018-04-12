<?php

namespace App;

use App\Contracts\Models\ITableTypeRow;
use Illuminate\Database\Eloquent\Model;

class TableTypeRow extends Model implements ITableTypeRow
{
    public $timestamps = false;

    public function setParentAttributeId(int $parentAttributeId): ITableTypeRow
    {
        $this->parent_attribute_id = $parentAttributeId;

        return $this;
    }

    public function getParentAttributeId(): int
    {
        return $this->parent_attribute_id;
    }

    public function setName(string $name): ITableTypeRow
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setId(int $id): ITableTypeRow
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
