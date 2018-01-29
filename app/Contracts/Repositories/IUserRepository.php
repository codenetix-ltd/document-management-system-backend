<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\IUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

interface IUserRepository
{
    public function create(IUser $user) : IUser;

    public function updateAvatar(IUser $user, int $fileId) : bool;

    public function findOrFail(int $id) : IUser;

    public function update(int $id, IUser $userInput, array $updatedFields): IUser;

    public function delete(int $id): ?bool;

    public function list(): LengthAwarePaginatorContract;
}