<?php

namespace App\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagListService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TagListService implements ITagListService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }
}