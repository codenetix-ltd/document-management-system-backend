<?php

namespace App\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Template;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TemplateService
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

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
    }

    public function get(int $id): Template
    {
        return $this->repository->findOrFail($id);
    }

    public function list(): LengthAwarePaginatorContract
    {
        return $this->repository->list();
    }

    public function update(int $id, Template $templateInput, array $updatedFields): Template
    {
        $template = $this->repository->update($id, $templateInput, $updatedFields);

        return $template;
    }
}
