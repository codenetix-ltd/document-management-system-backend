<?php

namespace App\Services;

use App\Entities\Document;
use App\Repositories\DocumentRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class DocumentService
{
    /**
     * @var DocumentRepository
     */
    protected $repository;

    /**
     * DocumentService constructor.
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository)
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
     * @return Document
     */
    public function find(int $id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return Document
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