<?php

namespace App\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateGetService;
use App\Template;

class TemplateGetService implements ITemplateGetService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): Template
    {
        return $this->repository->findOrFail($id);
    }
}