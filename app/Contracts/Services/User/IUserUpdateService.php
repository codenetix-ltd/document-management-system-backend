<?php

namespace App\Contracts\Services\User;

use App\User;
use Illuminate\Http\UploadedFile;

interface IUserUpdateService
{
    public function update(int $id, User $userInput, array $updatedFields, UploadedFile $file = null) : User;
}