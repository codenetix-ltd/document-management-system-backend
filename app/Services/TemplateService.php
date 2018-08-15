<?php

namespace App\Services;

use App\QueryParams\IQueryParamsObject;
use App\Entities\Template;
use App\Repositories\TemplateRepository;

class TemplateService
{
    use CRUDServiceTrait;

    /**
     * TemplateService constructor.
     * @param TemplateRepository $repository
     */
    public function __construct(TemplateRepository $repository)
    {
        $this->setRepository($repository);
    }
}
