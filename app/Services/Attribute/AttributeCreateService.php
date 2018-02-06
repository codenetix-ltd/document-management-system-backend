<?php

namespace App\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Services\Attribute\IAttributeCreateService;

class AttributeCreateService implements IAttributeCreateService
{
    private $repository;

    public function __construct(IAttributeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(IAttribute $attribute) : IAttribute
    {
        $attribute = $this->repository->create($attribute);

        return $attribute;
    }
}