<?php

namespace App\Services\User;

use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\User\IUserGetService;
use App\User;

class UserGetService implements IUserGetService
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): User
    {
        return $this->repository->findOrFail($id);
    }
}