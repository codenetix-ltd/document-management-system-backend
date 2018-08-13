<?php

namespace App\Services;

use App\Criteria\IQueryParamsObject;
use App\Entities\User;
use App\Events\Template\TemplateDeleteEvent;
use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @param IQueryParamsObject $queryParamsObject
     * @return mixed
     */
    public function paginate(IQueryParamsObject $queryParamsObject)
    {
        return $this->repository->paginateList($queryParamsObject);
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

        $this->repository->sync($user->id, 'templates', array_get($data, 'templatesIds'));
        $this->repository->sync($user->id, 'roles', array_get($data, 'rolesIds'));

        Event::dispatch(new UserCreateEvent($user));

        return $user;
    }

    /**
     * @param array $data
     * @param integer $id
     * @return User
     */
    public function update(array $data, int $id)
    {
        /** @var User $user */
        $user = $this->repository->update($data, $id);
        $this->repository->sync($user->id, 'templates', array_get($data, 'templatesIds'));
        $this->repository->sync($user->id, 'roles', array_get($data, 'rolesIds'));

        Event::dispatch(new UserUpdateEvent($user));

        return $user;
    }

    /**
     * @param integer $id
     * @return integer
     */
    public function delete(int $id): ?int
    {
        try {
            $user = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        Event::dispatch(new UserDeleteEvent($user));

        return $this->repository->delete($id);
    }
}
