<?php

namespace App\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Events\Template\TemplateCreateEvent;
use App\Events\Template\TemplateDeleteEvent;
use App\Events\Template\TemplateUpdateEvent;
use App\Services\Components\IEventDispatcher;
use App\Template;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TemplateService
{
    private $repository;
    /**
     * @var IEventDispatcher
     */
    private $eventDispatcher;

    public function __construct(ITemplateRepository $repository, IEventDispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(Template $template) : Template
    {
        $template = $this->repository->create($template);
        $this->eventDispatcher->dispatch(new TemplateCreateEvent($template));

        return $template;
    }

    public function delete(int $id): ?bool
    {
        $template = $this->repository->find($id);

        if(!$template) {
            return false;
        }

        $this->eventDispatcher->dispatch(new TemplateDeleteEvent($template));

        return $this->repository->delete($template->getId());
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
        $this->eventDispatcher->dispatch(new TemplateUpdateEvent($template));

        return $template;
    }
}
