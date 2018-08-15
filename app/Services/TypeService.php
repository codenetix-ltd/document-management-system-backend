<?php

namespace App\Services;

use App\Repositories\TypeRepository;

class TypeService
{
    use CRUDServiceTrait;

    const TYPE_STRING = 'string';
    const TYPE_NUMERIC = 'numeric';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_TABLE = 'table';

    /**
     * TypeService constructor.
     * @param TypeRepository $repository
     */
    public function __construct(TypeRepository $repository)
    {
        $this->setRepository($repository);
    }
}
