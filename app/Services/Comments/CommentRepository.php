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
        $levelDepth = ($this->config->get('comments.levelDepth') - 1);
        $comments = $this->container->make(Collection::class);
        $rootLevelComments = $this->getInstance()
            ->whereNull('parent_id')
            ->where([
                'commentable_type' => 'document',
                'commentable_id' => $documentId
            ])
            ->skip(($perPage*$pageNumber) - $perPage)
            ->take($perPage)
            ->get();

        $rootLevelCommentIds = $rootLevelComments->pluck('id');
        $comments = $comments->merge($rootLevelComments)->merge($this->paginateChildrenByRootCommentId($pageNumber, $rootLevelCommentIds, $levelDepth));
        return $strategy->make($comments);
    }

    /**
     * @param int $rootCommentId
     * @param int $pageNumber
     * @param ITransformerStrategy $strategy
     * @return mixed
     */
    public function paginateCommentsByRootCommentId(int $rootCommentId, int $pageNumber, ITransformerStrategy $strategy)
    {
        $levelDepth = $this->config->get('comments.levelDepth');
        $rootCommentIdCollection = $this->container->make(Collection::class);
        $rootCommentIdCollection->push($rootCommentId);
        $comments = $this->paginateChildrenByRootCommentId($pageNumber, $rootCommentIdCollection, $levelDepth);
        return $strategy->make($comments, $rootCommentId, $pageNumber);
    }

    /**
     * @param int $pageNumber
     * @param Collection $rootLevelCommentsIds
     * @param int $levelDepth
     * @return Collection
     */
    private function paginateChildrenByRootCommentId(int $pageNumber, Collection $rootLevelCommentsIds, int $levelDepth): Collection
    {
        $perPage = $this->config->get('comments.perPage');
        $comments = $this->container->make(Collection::class);
        for ($i = 0; $i < $levelDepth; $i++)
        {
            $currentChildLevelComments = $this->getInstance()
                ->whereIn('parent_id', $rootLevelCommentsIds)
                ->skip(($perPage*$pageNumber) - $perPage)
                ->take($perPage)
                ->get();

            $rootLevelCommentsIds = $currentChildLevelComments->pluck('id');
            $comments = $comments->merge($currentChildLevelComments);
        }

        return $comments;
    }
}