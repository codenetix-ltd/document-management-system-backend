<?php

namespace App\Contracts\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;

interface IAttributeGetService
{
    public function __construct(IAttributeRepository $repository, ITypeRepository $typeRepository);

    public function get(int $id) : IAttribute;
}