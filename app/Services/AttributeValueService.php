<?php

namespace App\Services;

use App\Entities\AttributeValue;
use App\Repositories\AttributeValueRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class AttributeValueService
{
    /**
     * @var AttributeValueRepository
     */
    protected $repository;

    /**
     * LabelService constructor.
     * @param AttributeValueRepository $repository
     */
    public function __construct(AttributeValueRepository $repository)
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
     * @return AttributeValue
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return AttributeValue
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
        $value = $this->repository->findWhere([['id', '=', $id]])->first();
        if (is_null($value)) {
            return null;
        }

        $this->repository->delete($id);
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }
}
