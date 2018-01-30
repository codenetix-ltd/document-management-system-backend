<?php

namespace App\Contracts\Services\User;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use Illuminate\Http\UploadedFile;

interface IUserUpdateService
{
    public function __construct(IUserRepository $repository, IUserAvatarUpdateService $userAvatarUpdateService);

    public function update(int $id, IUser $userInput, array $updatedFields, UploadedFile $file = null) : IUser;
}