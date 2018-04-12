<?php

namespace App\Services\Attribute;

use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Services\Attribute\IAttributeDeleteService;
use App\Exceptions\FailedAttributeDeleteException;

class AttributeDeleteService implements IAttributeDeleteService
{
    private $repository;

    public function __construct(IAttributeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws FailedAttributeDeleteException
     */
    public function delete(int $id): ?bool
    {
        $attribute = $this->repository->find($id);
        if (is_null($attribute)) {
            return null;
        }

        if ($attribute->getParentAttributeId()) {
            throw new FailedAttributeDeleteException('Removing an attribute that has a parent attribute is not possible');
        } else {
            return $this->repository->delete($id);
        }
    }
}