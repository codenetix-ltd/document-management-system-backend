<?php

namespace App\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Events\Label\LabelCreateEvent;
use App\Events\Label\LabelDeleteEvent;
use App\Events\Label\LabelUpdateEvent;
use App\Services\Components\IEventDispatcher;
use App\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Support\Collection;

class TagService
{
    private $repository;
    /**
     * @var IEventDispatcher
     */
    private $eventDispatcher;

    public function __construct(ITagRepository $repository, IEventDispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(Tag $tag) : Tag
    {
        $tag = $this->repository->create($tag);
        $this->eventDispatcher->dispatch(new LabelCreateEvent($tag));

        return $tag;
    }

    public function delete(int $id): ?bool
    {
        $tag = $this->repository->find($id);

        if(!$tag) {
            return false;
        }

        $this->eventDispatcher->dispatch(new LabelDeleteEvent($tag));

        return $this->repository->delete($tag->getId());
    }

    public function get(int $id): Tag
    {
        return $this->repository->findOrFail($id);
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }

    public function update(int $id, Tag $tagInput, array $updatedFields): Tag
    {
        $tag = $this->repository->update($id, $tagInput, $updatedFields);
        $this->eventDispatcher->dispatch(new LabelUpdateEvent($tag));

        return $tag;
    }
}
