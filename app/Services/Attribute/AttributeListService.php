<?php

namespace App\Services\Attribute;

use App\Attribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Services\Attribute\IAttributeGetService;
use App\Contracts\Services\Attribute\IAttributeListService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AttributeListService implements IAttributeListService
{
    private $repository;
    private $attributeGetService;

    public function __construct(IAttributeRepository $repository, IAttributeGetService $attributeGetService)
    {
        $this->repository = $repository;
        $this->attributeGetService = $attributeGetService;
    }

    public function list(): LengthAwarePaginator
    {
        $attributes = $this->repository->list();

        $attributes->getCollection()->transform(function ($attribute) {
            /** @var Attribute $attribute */
            return $this->attributeGetService->get($attribute->getId());
        });

        return $attributes;
    }
}