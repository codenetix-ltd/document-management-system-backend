<?php

namespace App\Services;

use App\Entities\User;
use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Event;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param bool $withCriteria
     * @return mixed
     */
    public function paginate($withCriteria = false)
    {
        return $this->repository->paginateList($withCriteria);
    }

    /**
     * @param integer $id
     * @return User
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        /** @var User $user */
        $user = $this->repository->create($data);
        $user->templates()->sync($data['templatesIds']);
        $user->roles()->sync($data['rolesIds']);

        Event::dispatch(new UserCreateEvent($user));

        return $user;
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return User
     */
    public function update(array $data, int $id)
    {
        /** @var User $user */
        $user = $this->repository->update($data, $id);
        $user->templates()->sync($data['templatesIds']);
        $user->roles()->sync($data['rolesIds']);

        Event::dispatch(new UserUpdateEvent($user));

        return $user;
    }

    /**
     * @param integer $id
     * @return integer
     */
    public function delete(int $id): int
    {
        $user = $this->repository->findModel($id);

        if (is_null($user)) {
            return 0;
        }

        Event::dispatch(new UserDeleteEvent($user));

        return $this->repository->delete($id);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id)
    {
        return $this->repository->findModel($id);
    }
}
