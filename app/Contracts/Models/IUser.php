<?php

namespace App\Contracts\Models;

interface IUser
{
    public function setId(int $id): self;
    public function getId(): int;

    public function setFullName(string $fullName): self;
    public function getFullName(): string;

    public function setEmail(string $email): self;
    public function getEmail(): string;

    public function setPassword(string $password): self;

    public function setCreated(string $created): self;
    public function getCreated(): string;

    public function setUpdated(string $updated): self;
    public function getUpdated(): string;

    public function setTemplatesIds(array $ids): self;
    public function getTemplatesIds(): ?array;
}