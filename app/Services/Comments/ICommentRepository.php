<?php

namespace App\Services\Comments;

/**
 * Interface ICommentRepository.
 */
interface ICommentRepository extends IRepository
{
    public function getCommentsByDocumentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy);

    public function getCommentsByRootCommentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy);

    public function getPageCommentsByDocumentId(int $documentId, int $pageNumber);

    public function getPageCommentsByRootCommentId(int $rootCommentId, int $pageNumber);

    public function findModel(int $id);

}