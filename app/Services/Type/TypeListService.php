<?php

namespace App\Services\Type;

use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\Type\ITypeListService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TypeListService implements ITypeListService
{
    private $repository;

    public function __construct(ITypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }
}