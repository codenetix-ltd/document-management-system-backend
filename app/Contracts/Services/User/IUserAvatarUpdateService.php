<?php

namespace App\Contracts\Services\User;

use App\User;
use Illuminate\Http\UploadedFile;

interface IUserAvatarUpdateService
{
    public function update(User $user, UploadedFile $file) : User;
}