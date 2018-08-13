<?php

namespace App\Services\Comments;

use App\Entities\Comment as CommentEntity;

interface IComment
{
    public function setId(int $id): void;
    public function getId(): int;
    public function setUserId(int $userId): void;
    public function getUserId(): int;
    public function setEntityId(int $entityId): void;
    public function getEntityId(): int;
    public function setEntityType(string $entityType): void;
    public function getEntityType(): string;
    public function setParentId($parentId): void;
    public function getParentId(): int;
    public function setMessage(string $message): void;
    public function getMessage(): string;
    public function setCreatedAt($createdAt): void;
    public function getCreatedAt(): int;
    public function setUpdatedAt($updatedAt): void;
    public function getUpdatedAt(): int;
    public function setDeletedAt($deletedAt): void;
    public function getDeletedAt(): int;
    public function setChildren(CommentsCollection $children): void;
    public function addComment(IComment $comment): void;
    public function getComments(): CommentsCollection;
    public function removeComment(IComment $comment): void;
}