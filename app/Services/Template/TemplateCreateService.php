<?php

namespace App\Services\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateCreateService;

class TemplateCreateService implements ITemplateCreateService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ITemplate $template) : ITemplate
    {
        $template = $this->repository->create($template);

        return $template;
    }
}