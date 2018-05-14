<?php

namespace App\Contracts\Repositories;

use App\User;

interface IUserRepository extends IRepository
{
    public function create(User $user) : User;

    public function updateAvatar(User $user, int $fileId) : bool;

    public function findOrFail(int $id) : User;
    public function find(int $id) : ?User;

    public function update(int $id, User $userInput, array $updatedFields): User;

    public function delete(int $id): ?bool;
}