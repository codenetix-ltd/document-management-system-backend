<?php

namespace App\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagDeleteService;

class TagDeleteService implements ITagDeleteService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
    }
}