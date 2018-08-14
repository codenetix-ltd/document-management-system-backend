<?php

namespace App\Services\Comments;

use App\Entities\Comment;
use Illuminate\Support\Collection;

/**
 * Class CommentRepository.
 */
class CommentRepository extends BaseRepository implements ICommentRepository
{
    private $transformer;
    private $collection;
    private $config;

    /**
     * CommentRepository constructor.
     * @param ITransformer $transformer
     * @param \Illuminate\Config\Repository $config
     * @param \Illuminate\Support\Collection $collection
     */
    public function __construct(ITransformer $transformer, \Illuminate\Config\Repository $config, \Illuminate\Support\Collection $collection)
    {
        $this->transformer = $transformer;
        $this->collection = $collection;
        $this->config = $config;
    }

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
    public function find(int $id)
    {
        $model = $this->getInstance()->findOrFail($id);
        return $this->transformer->transform($model);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $model = $this->getInstance()->create($data);
        $model = $this->getInstance()->findOrFail($model->id);
        return $this->transformer->transform($model);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $this->getInstance()->where('id', $id)->update($data);
        $model = $this->getInstance()->findOrFail($id);
        return $this->transformer->transform($model);
    }

    /**
     * @param int $documentId
     * @param int $pageNumber
     * @param ITransformerStrategy $strategy
     * @return mixed
     */
    public function paginateCommentsByDocumentId(int $documentId, int $pageNumber, ITransformerStrategy $strategy)
    {
        $perPage = $this->config->get('comments.perPage');
        $comments = $this->collection;

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
        $comments = $comments->merge($lvlComments)->merge($this->paginateComments($pageNumber, $lvlCommentIds));
        return $strategy->make($comments);
    }

    /**
     * @param int $commentId
     * @param int $pageNumber
     * @param ITransformerStrategy $strategy
     * @return mixed
     */
    public function paginateCommentsByRootCommentId(int $commentId, int $pageNumber, ITransformerStrategy $strategy)
    {
        $rootComment = $this->getInstance()
            ->where('id', $commentId)
            ->get();

        $lvlCommentIds = $rootComment->pluck('id');
        $comments = $this->paginateComments($pageNumber, $lvlCommentIds);

        return $strategy->make($comments, $commentId, $pageNumber);
    }
    
    private function paginateComments(int $pageNumber, Collection $lvlCommentIds): Collection
    {
        $perPage = $this->config->get('comments.perPage');
        $lvlDepth = $this->config->get('comments.lvlDepth');
        $comments = $this->collection;

        for ($i = 0; $i < $lvlDepth; $i++)
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