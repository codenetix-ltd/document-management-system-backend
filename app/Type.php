<?php

namespace App;

use App\Contracts\Models\IType;
use Illuminate\Database\Eloquent\Model;

class Type extends Model implements IType
{
    public function setId(int $id): IType
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): IType
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
