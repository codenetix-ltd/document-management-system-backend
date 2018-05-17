<?php

namespace App\Services;

use App\Repositories\TypeRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class TypeService
{
    const TYPE_STRING = 'string';
    const TYPE_NUMERIC = 'numeric';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_TABLE = 'table';

    /**
     * @var TypeRepository
     */
    protected $repository;

    /**
     * TypeService constructor.
     * @param TypeRepository $repository
     */
    public function __construct(TypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->repository->all();
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }
}