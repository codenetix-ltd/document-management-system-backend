<?php

namespace App\Services\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateUpdateService;

class TemplateUpdateService implements ITemplateUpdateService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(int $id, ITemplate $templateInput, array $updatedFields): ITemplate
    {
        $template = $this->repository->update($id, $templateInput, $updatedFields);

        return $template;
    }
}