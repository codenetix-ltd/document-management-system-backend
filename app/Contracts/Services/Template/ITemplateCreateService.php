<?php

namespace App\Contracts\Services\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Repositories\ITemplateRepository;

interface ITemplateCreateService
{
    public function __construct(ITemplateRepository $repository);

    public function create(ITemplate $template) : ITemplate;
}