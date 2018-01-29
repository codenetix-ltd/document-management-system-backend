<?php

namespace App\Contracts\Services\User;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;

interface IUserGetService
{
    public function __construct(IUserRepository $repository);

    public function get(int $id) : IUser;
}