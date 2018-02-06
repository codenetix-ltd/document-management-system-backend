<?php

namespace App\Contracts\Models;

interface IFile
{
    public function setCreatedAt($value);
    public function getCreatedAt(): string;

    public function setUpdatedAt($value);
    public function getUpdatedAt(): string;

    public function setId(int $id): self;
    public function getId(): int;

    public function setPath(string $path): self;
    public function getPath(): string;

    public function setOriginalName(string $originalName): self;
    public function getOriginalName(): string;
}