<?php

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     * @return mixed
     */
    public function paginate(){
        return $this->repository->paginate();
    }

    /**
     * @param int $id
     * @return User
     */
    public function find(int $id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data){
        /** @var User $user */
        $user = $this->repository->create($data);
        $user->templates()->sync($data['templateIds']);

        return $user;
    }

    /**
     * @param array $data
     * @param int $id
     * @return User
     */
    public function update(array $data, int $id){
        /** @var User $user */
        $user = $this->repository->update($data, $id);
        $user->templates()->sync($data['templateIds']);
        return $user;
    }

    /**
     * @param int $id
     */
    public function delete(int $id){

        $model = $this->repository->findWhere([['id', '=', $id]])->first();

        if (is_null($model)) {
            return;
        }

        $this->repository->delete($id);
    }
}