<?php

namespace App\Repositories;

use App\Contracts\Repositories\IUserRepository;
use App\Template;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class UserRepository implements IUserRepository
{
    public function create(User $user) : User
    {
        $user->save();

        if (is_array($user->getTemplatesIds())) {
            if (count($user->getTemplatesIds())) {
                $user->templates()->sync(Template::findMany($user->getTemplatesIds())->pluck('id'));
            } else {
                $user->templates()->detach();
            }
        }

        return $user;
    }

    public function updateAvatar(User $user, int $fileId): bool
    {
        $user->avatar_file_id = $fileId;

        return $user->save();
    }

    public function findOrFail(int $id): User
    {
        return User::findOrFail($id);
    }

    public function update(int $id, User $userInput, array $updatedFields): User
    {
        $user = User::findOrFail($id);

        //TODO - remove, refactoring
        foreach ($updatedFields as $fieldKey) {
            $user->{dms_build_setter($fieldKey)}($userInput->{dms_build_getter($fieldKey)}());
        }

        $user->save();

        //todo - вынести в отдельный метод
        if (is_array($userInput->getTemplatesIds())) {
            if (count($userInput->getTemplatesIds())) {
                $user->templates()->sync(Template::findMany($userInput->getTemplatesIds())->pluck('id'));
            } else {
                $user->templates()->detach();
            }
        }

        return $user;
    }

    public function delete(int $id): ?bool
    {
        return User::where('id', $id)->delete();
    }

    public function list(): LengthAwarePaginatorContract
    {
        return User::paginate();
    }
}