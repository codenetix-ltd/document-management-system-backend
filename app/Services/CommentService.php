<?php

namespace App\Services;

use App\Services\Comments\CommentsCollection;
use App\Services\Comments\CommentTransformerTreeStrategy;
use App\Services\Comments\ICommentRepository;
use App\Services\Comments\ITransformerStrategy;

class CommentService
{
    use CRUDServiceTrait;

    /**
     * @var ITransformerStrategy
     */
    protected $strategy;

    /**
     * CommentService constructor.
     * @param ICommentRepository $repository
     */
    public function __construct(ICommentRepository $repository)
    {
        $this->setRepository($repository);
    }

    /**
     * @param integer $documentId
     * @param integer $pageNumber
     * @return CommentsCollection
     */
    public function getCommentsTreeByDocumentId(int $documentId, int $pageNumber)
    {
        $this->strategy = new CommentTransformerTreeStrategy();
        return $this->repository->paginateCommentsByDocumentId($documentId, $pageNumber, $this->strategy);
    }

    /**
     * @param integer $commentId
     * @param integer $pageNumber
     * @return CommentsCollection
     */
    public function getCommentsTreeByRootCommentId(int $commentId, int $pageNumber)
    {
        $this->strategy = new CommentTransformerTreeStrategy();
        return $this->repository->paginateCommentsByRootCommentId($commentId, $pageNumber, $this->strategy);
    }
}
