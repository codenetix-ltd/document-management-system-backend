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
        return $this->repository->create($data);
    }

    public function update(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    public function getCommentsTreeByDocumentId(int $documentId, int $pageNumber)
    {
        $this->strategy = new CommentTransformerTreeStrategy();
        return $this->repository->paginateCommentsByDocumentId($documentId, $pageNumber, $this->strategy);
    }

    public function getCommentsTreeByRootCommentId(int $commentId, int $pageNumber)
    {
        $this->strategy = new CommentTransformerTreeStrategy();
        return $this->repository->paginateCommentsByRootCommentId($commentId, $pageNumber, $this->strategy);
    }
}