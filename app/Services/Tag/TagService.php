<?php

namespace App\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Support\Collection;

class TagService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Tag $tag) : Tag
    {
        $tag = $this->repository->create($tag);

        return $tag;
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
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

        return $tag;
    }
}
