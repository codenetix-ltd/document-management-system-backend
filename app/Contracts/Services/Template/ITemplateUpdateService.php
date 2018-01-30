<?php

namespace App\Contracts\Services\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Repositories\ITemplateRepository;

interface ITemplateUpdateService
{
    public function __construct(ITemplateRepository $repository);

    public function update(int $id, ITemplate $templateInput, array $updatedFields) : ITemplate;
}