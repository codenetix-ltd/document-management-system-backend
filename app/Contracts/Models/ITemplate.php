<?php

namespace App\Contracts\Models;

interface ITemplate
{
    public function setId(int $id): self;
    public function getId(): int;

    public function setName(string $name): self;
    public function getName(): string;

    //TODO - вынести поля даты в отдельный интерфейс
    public function setCreatedAt($value);
    public function getCreatedAt(): string;

    public function setUpdatedAt($value);
    public function getUpdatedAt(): string;
}