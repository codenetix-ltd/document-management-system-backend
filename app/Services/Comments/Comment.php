<?php

namespace App\Services\Comments;

class Comment implements IComment
{
    private $id;
    private $userId;
    private $commentableId;
    private $commentableType;
    private $parentId;
    private $message;
    private $createdAt;
    private $updatedAt;
    private $deletedAt;
    private $children;

    /**
     * Comment constructor.
     * @param int $pageNumber
     */
    public function __construct($pageNumber = 1)
    {
        $this->children = new CommentsCollection([], $pageNumber);
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
     * @param int $commentableId
     * @return void
     */
    public function setEntityId(int $commentableId): void
    {
        $this->commentableId = $commentableId;
    }

    /**
     * Get comment commentable id
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->commentableId;
    }

    /**
     * Set comment commentable type
     * @param string $commentableType
     * @return void
     */
    public function setEntityType(string $commentableType): void
    {
        $this->commentableType = $commentableType;
    }

    /**
     * Get comment commentable type
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->commentableType;
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
    public function getParentId(): ?int
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
    public function setCreatedAt(int $createdAt): void
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
    public function setUpdatedAt(int $updatedAt): void
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
    public function setDeletedAt(?int $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Get deleted time
     * @return int
     */
    public function getDeletedAt(): ?int
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
     * @param int $id
     * @return void
     */
    public function removeCommentById(int $id): void
    {
        $this->children->where('id', $id)->forget($id);
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