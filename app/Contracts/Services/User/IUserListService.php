<?php

namespace App\Contracts\Services\User;

use App\Contracts\Repositories\IUserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

interface IUserListService
{
    public function __construct(IUserRepository $repository);

    public function list(): LengthAwarePaginatorContract;
}