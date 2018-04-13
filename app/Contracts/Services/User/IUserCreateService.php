<?php

namespace App\Contracts\Services\User;

use App\User;
use Illuminate\Http\UploadedFile;

interface IUserCreateService
{
    public function create(User $user, UploadedFile $file = null) : User;
}