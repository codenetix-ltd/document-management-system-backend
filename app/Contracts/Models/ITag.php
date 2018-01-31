<?php

namespace App\Contracts\Models;

interface ITag
{
    public function setId(int $id): self;
    public function getId(): int;

    public function setName(string $name): self;
    public function getName(): string;

    public function setCreated(string $created): self;
    public function getCreated(): string;

    public function setUpdated(string $updated): self;
    public function getUpdated(): string;
}