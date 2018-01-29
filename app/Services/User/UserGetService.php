<?php

namespace App\Services\User;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\User\IUserGetService;

class UserGetService implements IUserGetService
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): IUser
    {
        return $this->repository->findOrFail($id);
    }
}