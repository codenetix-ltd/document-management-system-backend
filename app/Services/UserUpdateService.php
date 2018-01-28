<?php

namespace App\Services;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\IUserAvatarUpdateService;
use App\Contracts\Services\IUserUpdateService;
use Illuminate\Http\UploadedFile;

class UserUpdateService implements IUserUpdateService
{
    private $repository;

    private $userAvatarUpdateService;

    public function __construct(IUserRepository $repository, IUserAvatarUpdateService $userAvatarUpdateService)
    {
        $this->repository = $repository;
        $this->userAvatarUpdateService = $userAvatarUpdateService;
    }

    public function update(int $id, IUser $userInput, array $updatedFields, UploadedFile $file = null): IUser
    {
        $user = $this->repository->update($id, $userInput, $updatedFields);

        if ($file) {
            $user = $this->userAvatarUpdateService->update($user, $file);
        }

        return $user;
    }
}