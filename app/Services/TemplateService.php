<?php

namespace App\Services;

use App\Entities\Template;
use App\Repositories\TemplateRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id)
    {
        $template = $this->repository->findWhere([['id', '=', $id]])->first();
        if (is_null($template)) {
            return null;
        }

        $this->repository->delete($id);
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }
}
