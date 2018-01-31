<?php

namespace App\Contracts\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Services\Base\IListService;

interface ITemplateListService extends IListService
{
    public function __construct(ITemplateRepository $repository);
}