<?php

namespace App\Services;

use App\Entities\Template;
use App\Repositories\TemplateRepository;

class TemplateService
{
    /**
     * @var TemplateRepository
     */
    protected $repository;

    /**
     * TemplateService constructor.
     * @param TemplateRepository $repository
     */
    public function __construct(TemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->repository->all();
    }

    /**
     * @param integer $id
     * @return Template
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return Template
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return Template
     */
    public function update(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param integer $id
     * @return integer
     */
    public function delete(int $id): int
    {
        $template = $this->repository->findModel($id);
        if (is_null($template)) {
            return 0;
        }

        return $this->repository->delete($id);
    }

    /**
     * @return mixed
     */
    public function paginate()
    {
        return $this->repository->paginate();
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
