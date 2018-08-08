<?php

namespace App\Services\Comments;

use App\Entities\Comment as CommentEntity;

class Comment implements IComment
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
    protected $children;

    /**
     * Comment constructor.
     * @param int $pageNumber
     */
    public function __construct($pageNumber = 1)
    {
        $this->children = new CommentsCollection([], $pageNumber);
    }

    /**
     * Set all comment property
     * @param CommentEntity $comment
     * @return void
     */
    public function setAllProperty(CommentEntity $comment): void
    {
        $this->setId($comment->id);
        $this->setUserId($comment->user_id);
        $this->setEntityId($comment->commentable_id);
        $this->setEntityType($comment->commentable_type);
        $this->setParentId($comment->parent_id);
        $this->setMessage($comment->body);
        $this->setCreatedAt($comment->created_at);
        $this->setUpdatedAt($comment->updated_at);
        $this->setDeletedAt($comment->deleted_at);
    }

    /**
     * Set comment id
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get comment id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set comment user id
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Get comment user id
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set comment commentable id
     * @param int $entityId
     * @return void
     */
    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * Get comment commentable id
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * Set comment commentable type
     * @param string $entityType
     * @return void
     */
    public function setEntityType(string $entityType): void
    {
        $this->entityType = $entityType;
    }

    /**
     * Get comment commentable type
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * Set comment parent id
     * @param $parentId
     * @return void
     */
    public function setParentId($parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * Get comment parent id
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * Set comment message
     * @param $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Get comment message
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set created time
     * @param $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get created time
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * Set updated time
     * @param $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updated time
     * @return int
     */
    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }

    /**
     * Set deleted time
     * @param $deletedAt
     * @return void
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Get deleted time
     * @return int
     */
    public function getDeletedAt(): int
    {
        return $this->deletedAt;
    }

    /**
     * Set comment children
     * @param CommentsCollection
     * @return void
     */
    public function setChildren(CommentsCollection $children): void
    {
        $this->children = $children;
    }

    /**
     * Add comment to tree
     * @param IComment $comment
     * @return void
     */
    public function addComment(IComment $comment): void
    {
        $this->children->push($comment);
    }

    /**
     * Remove comment from tree
     * @param IComment $comment
     * @return void
     */
    public function removeComment(IComment $comment): void
    {
        //TODO: with collection remove!!!
    }

    /**
     * Get comments from tree
     * @return CommentsCollection
     */
    public function getComments(): CommentsCollection
    {
        return $this->children;
    }
}