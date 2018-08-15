<?php

namespace App\Services;

use App\Entities\AttributeValue;
use App\Repositories\AttributeValueRepository;

class AttributeValueService
{
    use CRUDServiceTrait;

    /**
     * LabelService constructor.
     * @param AttributeValueRepository $repository
     */
    public function __construct(AttributeValueRepository $repository)
    {
        $this->setRepository($repository);
    }
}
