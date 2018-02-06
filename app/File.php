<?php

namespace App;

use App\Contracts\Models\IFile;
use Illuminate\Database\Eloquent\Model;

class File extends Model implements IFile
{
    //TODO - remove from here
    protected $fillable = ['path', 'original_name'];

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setId(int $id): IFile
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setPath(string $path): IFile
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setOriginalName(string $originalName): IFile
    {
        $this->original_name = $originalName;

        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->original_name;
    }
}
