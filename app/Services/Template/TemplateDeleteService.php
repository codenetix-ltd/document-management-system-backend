<?php

namespace App\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateDeleteService;

class TemplateDeleteService implements ITemplateDeleteService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
    }
}