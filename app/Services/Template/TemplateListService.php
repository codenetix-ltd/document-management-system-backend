<?php

namespace App\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Template\ITemplateListService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TemplateListService implements ITemplateListService
{
    private $repository;

    public function __construct(ITemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }
}