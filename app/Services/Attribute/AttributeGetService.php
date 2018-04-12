<?php

namespace App\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\Attribute\IAttributeGetService;

class AttributeGetService implements IAttributeGetService
{
    private $repository;
    private $typeRepository;

    public function __construct(IAttributeRepository $repository, ITypeRepository $typeRepository)
    {
        $this->repository = $repository;
        $this->typeRepository = $typeRepository;
    }

    public function get(int $id): IAttribute
    {
        // TODO: Implement get() method.
    }
}