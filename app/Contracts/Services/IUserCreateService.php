<?php

namespace App\Contracts\Services;

use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IUserRepository;
use Illuminate\Http\UploadedFile;

interface IUserCreateService
{
    public function __construct(IUserRepository $repository, IUserAvatarUpdateService $userAvatarUpdateService);

    public function create(IUser $user, UploadedFile $file = null) : IUser;
}