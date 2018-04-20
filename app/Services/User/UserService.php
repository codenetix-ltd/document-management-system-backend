<?php

namespace App\Services\User;

use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\File\IFileManager;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class UserService
{
    private $repository;

    private $fileManager;

    public function __construct(IUserRepository $repository, IFileManager $fileManager)
    {
        $this->repository = $repository;
        $this->fileManager = $fileManager;
    }

    public function updateAvatar(User $user, UploadedFile $file): User
    {
        $file = $this->fileManager->createImageFile($file, config('filesystems.paths.avatars'));

        //TODO - remove old avatar
        $this->repository->updateAvatar($user, $file->id);

        return $user;
    }

    public function create(User $user, UploadedFile $file = null) : User
    {
        $user = $this->repository->create($user);
        if ($file) {
            $user = $this->updateAvatar($user, $file);
        }

        return $user;
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
    }

    public function get(int $id): User
    {
        return $this->repository->findOrFail($id);
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }

    public function update(int $id, User $userInput, array $updatedFields, UploadedFile $file = null): User
    {
        $user = $this->repository->update($id, $userInput, $updatedFields);

        if ($file) {
            $user = $this->updateAvatar($user, $file);
        }

        return $user;
    }
}
