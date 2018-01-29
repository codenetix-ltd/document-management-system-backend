<?php

namespace App\Services\User;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\File\IFileManager;
use App\Contracts\Services\User\IUserAvatarUpdateService;
use Illuminate\Http\UploadedFile;

class UserAvatarUpdateService implements IUserAvatarUpdateService
{
    private $repository;

    private $fileManager;

    public function __construct(IUserRepository $repository, IFileManager $fileManager)
    {
        $this->repository = $repository;
        $this->fileManager = $fileManager;
    }

    public function update(IUser $user, UploadedFile $file): IUser
    {
        $file = $this->fileManager->createImageFile($file, config('filesystems.paths.avatars'));

        //TODO - remove old avatar
        $this->repository->updateAvatar($user, $file->id);

        return $user;
    }
}