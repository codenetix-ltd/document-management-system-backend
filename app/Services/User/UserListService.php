<?php

namespace App\Services\User;

use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\User\IUserListService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class UserListService implements IUserListService
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }
}