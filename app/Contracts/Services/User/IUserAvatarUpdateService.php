<?php

namespace App\Contracts\Services\User;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\File\IFileManager;
use Illuminate\Http\UploadedFile;

interface IUserAvatarUpdateService
{
    public function __construct(IUserRepository $repository, IFileManager $fileManager);

    public function update(IUser $user, UploadedFile $file) : IUser;
}