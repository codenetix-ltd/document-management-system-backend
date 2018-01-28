<?php

namespace App\Services;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\IUserAvatarUpdateService;
use App\Contracts\Services\IUserCreateService;
use Illuminate\Http\UploadedFile;

class UserCreateService implements IUserCreateService
{
    private $repository;

    private $userAvatarUpdateService;

    public function __construct(IUserRepository $repository, IUserAvatarUpdateService $userAvatarUpdateService)
    {
        $this->repository = $repository;
        $this->userAvatarUpdateService = $userAvatarUpdateService;
    }

    public function create(IUser $user, UploadedFile $file = null) : IUser
    {
        $user = $this->repository->create($user);

        if ($file) {
            $user = $this->userAvatarUpdateService->update($user, $file);
        }

        return $user;
    }
}