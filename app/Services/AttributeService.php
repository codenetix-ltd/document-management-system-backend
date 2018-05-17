<?php

namespace App\Services;

use App\Entities\Attribute;
use App\Repositories\AttributeRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class AttributeService
{
    /**
     * @var AttributeRepository
     */
    protected $repository;

    /**
     * AttributeService constructor.
     * @param AttributeRepository $repository
     */
    public function __construct(AttributeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function list(){
        return $this->repository->all();
    }

    /**
     * @param int $id
     * @return Attribute
     */
    public function find(int $id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return Attribute
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
        return $this->repository->update($data, $id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id){
        $this->repository->delete($id);
    }

    public function paginate(){
        return $this->repository->paginate();
    }
}