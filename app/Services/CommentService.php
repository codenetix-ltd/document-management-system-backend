<?php

namespace App\Services;

use App\Services\Comments\CommentTransformerTreeStrategy;
use App\Services\Comments\ICommentRepository;

class CommentService
{
    protected $repository;
    protected $strategy;

    public function __construct(ICommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        $this->repository->all();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        $comment = $this->repository->create($data);
        return $comment;
    }

    public function update(array $data, int $id)
    {
        $comment = $this->repository->update($data, $id);
        return $comment;
    }

    public function delete(int $id)
    {
        $comment = $this->repository->findModel($id);

        if (is_null($comment)) {
            return 0;
        }

        return $this->repository->delete($id);
    }

    public function getCommentsTreeByDocumentId(int $documentId, int $pageNumber)
    {
        $this->strategy = new CommentTransformerTreeStrategy();

        $comments = $this->repository->getCommentsByDocumentId($documentId, $pageNumber, $this->strategy);
        return $comments;
    }

    public function getCommentsTreeByRootCommentId(int $commentId, int $pageNumber)
    {
        $this->strategy = new CommentTransformerTreeStrategy();

        $comments = $this->repository->getCommentsByRootCommentId($commentId, $pageNumber, $this->strategy);
        return $comments;
    }
}