<?php

namespace App\Services\Comments;

/**
 * Interface ICommentRepository.
 */
interface ICommentRepository extends IRepository
{
    /**
     * @param integer              $commentId
     * @param integer              $pageNumber
     * @param ITransformerStrategy $strategy
     * @return mixed
     */
    public function paginateCommentsByDocumentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy);

    /**
     * @param integer              $commentId
     * @param integer              $pageNumber
     * @param ITransformerStrategy $strategy
     * @return mixed
     */
    public function paginateCommentsByRootCommentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy);
}
