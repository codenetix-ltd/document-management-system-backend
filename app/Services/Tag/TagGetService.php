<?php

namespace App\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagGetService;
use App\Tag;

class TagGetService implements ITagGetService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): Tag
    {
        return $this->repository->findOrFail($id);
    }
}