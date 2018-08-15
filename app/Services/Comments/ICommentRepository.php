<?php

namespace App\Services\Comments;

/**
 * Interface ICommentRepository.
 */
interface ICommentRepository extends IRepository
{
    public function paginateCommentsByDocumentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy);
    public function paginateCommentsByRootCommentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy);
}
