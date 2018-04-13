<?php

namespace App\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateUpdateService;
use App\Template;

class TemplateUpdateService implements ITemplateUpdateService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(int $id, Template $templateInput, array $updatedFields): Template
    {
        $template = $this->repository->update($id, $templateInput, $updatedFields);

        return $template;
    }
}