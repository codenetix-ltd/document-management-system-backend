<?php

namespace App\Contracts\Services\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Repositories\ITemplateRepository;

interface ITemplateGetService
{
    public function __construct(ITemplateRepository $repository);

    public function get(int $id) : ITemplate;
}