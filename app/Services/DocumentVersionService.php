<?php

namespace App\Services;

use App\Entities\DocumentVersion;
use App\Repositories\DocumentVersionRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class DocumentVersionService
{
    /**
     * @var DocumentVersionRepository
     */
    protected $repository;

    /**
     * DocumentVersionService constructor.
     * @param DocumentVersionRepository $repository
     */
    public function __construct(DocumentVersionRepository $repository)
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
     * @return DocumentVersion
     */
    public function find(int $id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return DocumentVersion
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