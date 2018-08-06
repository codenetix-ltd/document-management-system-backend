<?php

namespace App\Services\Comments;

use App\Entities\Comment;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentCommentRepository.
 */
class CommentRepository extends BaseRepository implements ICommentRepository
{

    /**
     * @return Comment
     */
    function getInstance()
    {
        return new Comment();
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
        //dd($comments);
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
        $transformedComments = $strategy->make($comments);
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

//        return $this->getInstance()
//            ->where([
//                ['commentable_id', '=', $documentId],
//                ['commentable_type', '=', 'document']
//            ])
//            ->skip(($perPage*$pageNumber) - $perPage)
//            ->take($perPage)
//            ->get();

        $parentComments = DB::table('comments')
            ->whereNull('parent_id')
            ->skip(($perPage*$pageNumber) - $perPage)
            ->take($perPage)
            ->get();

//        dd($parentComments);

        $firstLvlComments = DB::table('comments as sub')
            ->join('comments as parent', 'parent.parent_id', '=', 'sub.id')
            ->whereNull('sub.parent_id')
            ->skip(($perPage*$pageNumber) - $perPage)
            ->take($perPage)
            ->get();

        $secondLvlComments = DB::table('comments as sub')
            ->join('comments as parent1', 'parent1.parent_id', '=', 'sub.id')
            ->join('comments as parent2', 'parent2.parent_id', '=', 'parent1.id')
            ->whereNull('sub.parent_id')
            ->skip(($perPage*$pageNumber) - $perPage)
            ->take($perPage)
            ->get();

//        dd($secondLvlComments);

        $comments = collect()
            ->push($parentComments)
            ->push($firstLvlComments)
            ->push($secondLvlComments);

//        dump($comments);

        for ($i = 0; $i <= $lvlDepth; $i++ )
        {

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

        return $this->getInstance()
            ->where('parent_id', $rootCommentId)
            ->skip(($perPage*$pageNumber) - $perPage)
            ->take($perPage)
            ->get();
    }
}