<?php

namespace App\Services\Comments;

abstract class AComment
{
    protected $id;
    protected $userId;
    protected $entityId;
    protected $entityType;
    protected $parentId;
    protected $message;
    protected $createdAt;
    protected $updatedAt;
    protected $deletedAt;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityType(string $entityType): void
    {
        $this->entityType = $entityType;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }

    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedAt(): int
    {
        return $this->deletedAt;
    }
}