<?php

namespace App\Contracts\Models;

interface IAttribute
{
    public function setId(int $id): self;
    public function getId(): int;

    public function setName(string $name): self;
    public function getName(): string;

    public function setTemplateId(int $templateId): self;
    public function getTemplateId(): int;

    public function setTypeId(int $typeId): self;
    public function getTypeId(): int;

    public function setLocked(bool $isLocked): self;
    public function isLocked(): bool;

    public function setData(array $data): self;
    public function getData(): ?array;

    public function setOrder(int $order): self;
    public function getOrder(): int;

    public function setCreatedAt($value);
    public function getCreatedAt(): string;

    public function setUpdatedAt($value);
    public function getUpdatedAt(): string;

    public function setParentAttributeId(int $parentAttributeId): self;
    public function getParentAttributeId(): ?int;

    public function setTableTypeColumnId(int $tableTypeColumnId): self;
    public function getTableTypeColumnId(): ?int;

    public function setTableTypeRowId(int $tableTypeRowId): self;
    public function getTableTypeRowId(): ?int;
}