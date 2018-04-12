<?php

namespace App\Contracts\Models;

interface ITableTypeColumn
{
    public function setId(int $id): self;
    public function getId(): int;

    public function setParentAttributeId(int $parentAttributeId): self;
    public function getParentAttributeId(): int;

    public function setName(string $name): self;
    public function getName(): string;
}