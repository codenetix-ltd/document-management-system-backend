<?php

namespace App\Services\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateGetService;

class TemplateGetService implements ITemplateGetService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): ITemplate
    {
        return $this->repository->findOrFail($id);
    }
}