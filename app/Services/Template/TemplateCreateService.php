<?php

namespace App\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateCreateService;
use App\Template;

class TemplateCreateService implements ITemplateCreateService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Template $template) : Template
    {
        $template = $this->repository->create($template);

        return $template;
    }
}