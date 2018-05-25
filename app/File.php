<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * @package App
 *
 * @property int $id
 */
class File extends Model
{
    protected $fillable = ['path', 'original_name'];

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
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

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setOriginalName(string $originalName): self
    {
        $this->original_name = $originalName;

        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->original_name;
    }
}
