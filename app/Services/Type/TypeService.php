<?php

namespace App\Services\Type;

use App\Contracts\Repositories\ITypeRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TypeService
{
    const TYPE_STRING = 'string';
    const TYPE_NUMERIC = 'numeric';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_TABLE = 'table';

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