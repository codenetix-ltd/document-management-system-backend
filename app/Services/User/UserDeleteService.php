<?php

namespace App\Services\User;

use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\User\IUserDeleteService;

class UserDeleteService implements IUserDeleteService
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
    }
}