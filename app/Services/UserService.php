<?php

namespace App\Services;

use App\Entities\User;
use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;

class UserService
{
    use CRUDServiceTrait;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->setRepository($repository);

        $this->setModelCreateEventClass(UserCreateEvent::class);
        $this->setModelUpdateEventClass(UserUpdateEvent::class);
        $this->setModelDeleteEventClass(UserDeleteEvent::class);
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
     * @return integer
     */
    public function getUniqueVisitorsTodayTotal(): int
    {
        return $this->repository->getUniqueUsersTotalByDate(Carbon::today());
    }

    /**
     * @param User $user
     * @return
     */
    public function touchUserLastActivityDateTime(User $user){
        return $this->repository->touchLastActivityDateTimeByUserId($user->id);
    }
}
