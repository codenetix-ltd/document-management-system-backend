<?php

namespace App\Services\Comments;

use App\Entities\Comment;
use Illuminate\Database\Eloquent\Collection;
/**
 * Class CommentCommentRepository.
 */
class CommentRepository extends BaseRepository implements ICommentRepository
{

    /**
     * @return Comment
     */
    public function getInstance()
    {
        return new Comment();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findModel(int $id)
    {
        return $this->getInstance()->find($id);
    }

    /**
     * @param int $documentId
     * @param int $pageNumber
     * @param ITransformerStrategy $strategy
     * @return mixed
     */
    public function getCommentsByDocumentId(int $documentId, int $pageNumber, ITransformerStrategy $strategy)
    {
        $comments = $this->getPageCommentsByDocumentId($documentId, $pageNumber);
        $transformedComments = $strategy->make($comments);
        return $transformedComments;
    }

    /**
     * @param int $commentId
     * @param int $pageNumber
     * @param ITransformerStrategy $strategy
     * @return mixed
     */
    public function getCommentsByRootCommentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy)
    {
        $comments = $this->getPageCommentsByRootCommentId($commentId, $pageNumber);
        $transformedComments = $strategy->make($comments, $commentId);
        return $transformedComments;
    }


    /**
     * @param int $documentId
     * @param int $pageNumber
     * @return \Illuminate\Support\Collection
     */
    public function getPageCommentsByDocumentId(int $documentId, int $pageNumber)
    {
        $perPage = config('comments.perPage');
        $lvlDepth = config('comments.lvlDepth');
        $comments = collect();

        $lvlComments = $this->getInstance()
            ->whereNull('parent_id')
            ->where([
                'commentable_type' => 'document',
                'commentable_id' => $documentId
            ])
            ->skip(($perPage*$pageNumber) - $perPage)
            ->take($perPage)
            ->get();

        $lvlCommentIds = $lvlComments->pluck('id');

        $comments = $comments->merge($lvlComments);

        for ($i = 1; $i < $lvlDepth; $i++)
        {
            $lvlComments = $this->getInstance()
                ->whereIn('parent_id', $lvlCommentIds)
                ->skip(($perPage*$pageNumber) - $perPage)
                ->take($perPage)
                ->get();

            $lvlCommentIds = $lvlComments->pluck('id');

            $comments = $comments->merge($lvlComments);
        }

        return $comments;
    }

    /**
     * @param int $rootCommentId
     * @param int $pageNumber
     * @return mixed
     */
    public function getPageCommentsByRootCommentId(int $rootCommentId, int $pageNumber)
    {
        $perPage = config('comments.perPage');
        $lvlDepth = config('comments.lvlDepth');
        $comments = collect();

        $rootComment = $this->getInstance()
            ->where('id', $rootCommentId)
            ->get();

        $lvlCommentIds = $rootComment->pluck('id');

        for ($i = 1; $i < $lvlDepth; $i++)
        {
            $lvlComments = $this->getInstance()
                ->whereIn('parent_id', $lvlCommentIds)
                ->skip(($perPage*$pageNumber) - $perPage)
                ->take($perPage)
                ->get();

            $lvlCommentIds = $lvlComments->pluck('id');

            $comments = $comments->merge($lvlComments);
        }

        return $comments;
    }
}