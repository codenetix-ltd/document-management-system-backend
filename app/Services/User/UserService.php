<?php

namespace App\Services\User;

use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\File\IFileManager;
use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use App\Services\Components\IEventDispatcher;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class UserService
{
    private $repository;

    private $fileManager;
    /**
     * @var IEventDispatcher
     */
    private $eventDispatcher;

    public function __construct(IUserRepository $repository, IFileManager $fileManager, IEventDispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->fileManager = $fileManager;
        $this->eventDispatcher = $eventDispatcher;
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
        $this->eventDispatcher->dispatch(new UserCreateEvent($user));

        return $user;
    }

    public function delete(int $id): ?bool
    {
        $user = $this->repository->find($id);

        if(!$user) {
            return false;
        }

        $this->eventDispatcher->dispatch(new UserDeleteEvent($user));

        return $this->repository->delete($user->getId());
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
        $this->eventDispatcher->dispatch(new UserUpdateEvent($user));

        return $user;
    }
}
