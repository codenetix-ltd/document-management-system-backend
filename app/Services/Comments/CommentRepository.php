<?php

namespace App\Services\Comments;

use App\Entities\Comment;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class CommentRepository.
 */
class CommentRepository extends BaseRepository implements ICommentRepository
{
    private $container;
    private $config;

    /**
     * CommentRepository constructor.
     * @param Repository $config
     * @param Container $container
     */
    public function __construct(Repository $config, Container $container)
    {
        $this->container = $container;
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
        $transformer = $this->container->make(CommentTransformer::class);
        $model = $this->getInstance()->findOrFail($id);
        return $transformer->transform($model);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $transformer = $this->container->make(CommentTransformer::class);
        $model = $this->getInstance()->create($data);
        $model = $this->getInstance()->findOrFail($model->id);
        return $transformer->transform($model);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $transformer = $this->container->make(CommentTransformer::class);
        $this->getInstance()->where('id', $id)->update($data);
        $model = $this->getInstance()->findOrFail($id);
        return $transformer->transform($model);
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
        $comments = $this->container->make(Collection::class);

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
        $comments = $this->container->make(Collection::class);

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