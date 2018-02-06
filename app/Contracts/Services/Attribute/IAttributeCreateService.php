<?php

namespace App\Contracts\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\IAttributeRepository;

interface IAttributeCreateService
{
    public function __construct(IAttributeRepository $repository);

    public function create(IAttribute $attribute) : IAttribute;
}