<?php

namespace App\Services;

use App\Entities\Label;
use App\Repositories\LabelRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class LabelService
{
    /**
     * @var LabelRepository
     */
    protected $repository;

    /**
     * LabelService constructor.
     * @param LabelRepository $repository
     */
    public function __construct(LabelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function list(){
        return $this->repository->paginate();
    }

    /**
     * @param int $id
     * @return Label
     */
    public function find(int $id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return Label
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
}