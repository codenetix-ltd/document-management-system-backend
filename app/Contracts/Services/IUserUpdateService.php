<?php

namespace App\Contracts\Services;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use Illuminate\Http\UploadedFile;

interface IUserUpdateService
{
    public function __construct(IUserRepository $repository, IUserAvatarUpdateService $userAvatarUpdateService);

    public function update(int $id, IUser $user, array $updatedFields, UploadedFile $file = null) : IUser;
}