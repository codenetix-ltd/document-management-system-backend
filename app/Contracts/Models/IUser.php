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

    public function setTemplatesIds(array $ids): self;
    public function getTemplatesIds(): ?array;

    public function getAvatar(): IFile;

    public function setCreatedAt($value);
    public function getCreatedAt(): string;

    public function setUpdatedAt($value);
    public function getUpdatedAt(): string;
}