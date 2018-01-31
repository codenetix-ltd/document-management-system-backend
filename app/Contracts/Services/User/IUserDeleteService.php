<?php

namespace App\Contracts\Services\User;

use App\Contracts\Repositories\IUserRepository;

interface IUserDeleteService
{
    public function __construct(IUserRepository $repository);

    public function delete(int $id) : ?bool;
}