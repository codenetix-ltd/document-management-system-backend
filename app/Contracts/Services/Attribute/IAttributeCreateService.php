<?php

namespace App\Contracts\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;

interface IAttributeCreateService
{
    public function __construct(IAttributeRepository $repository, ITypeRepository $typeRepository, IAttributeGetService $attributeGetService);

    public function create(IAttribute $attribute, int $templateId) : IAttribute;
}