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
        return $this->repository->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id){
        $data['avatarFileId'] = $data['avatarId'];
        return $this->repository->update($data, $id);
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