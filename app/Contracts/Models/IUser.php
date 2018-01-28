<?php

namespace App\Contracts\Models;

interface IUser
{
    public function setId(int $id): IUser;
    public function getId(): int;

    public function setFullName(string $fullName): IUser;
    public function getFullName(): string;

    public function setEmail(string $email): IUser;
    public function getEmail(): string;

    public function setPassword(string $password): IUser;

    public function setCreated(string $created): IUser;
    public function getCreated(): string;

    public function setUpdated(string $updated): IUser;
    public function getUpdated(): string;

    public function setTemplatesIds(array $ids): IUser;
    public function getTemplatesIds(): ?array;
}