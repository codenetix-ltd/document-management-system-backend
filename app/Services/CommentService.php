<?php

namespace App\Services;

use App\Services\Comments\CommentTransformerTreeStrategy;
use App\Services\Comments\ICommentRepository;
use App\Services\Comments\ITransformerStrategy;

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
        $comment = $this->repository->find($id);

        if (is_null($comment)) {
            return 0;
        }

        return $this->repository->delete($id);
    }

    public function getCommentsTreeByDocumentId(int $documentId, int $pageNumber)
    {
        $strategy = new CommentTransformerTreeStrategy();

        $comments = $this->repository->getCommentsByDocumentId($documentId, $pageNumber, $strategy);

        return $comments;
    }

    public function getCommentsByRootCommentId(int $commentId, int $pageNumber)
    {
        $strategy = new CommentTransformerTreeStrategy();

        $comments = $this->repository->getCommentsByRootCommentId($commentId, $pageNumber, $strategy);
        return $comments;
    }
}


//        uses???
//        $this->repository->sync($comment->id, 'documents', array_get($data, 'document_id'));
//        $this->repository->sync($comment->id, 'users', array_get($data, 'user_id'));