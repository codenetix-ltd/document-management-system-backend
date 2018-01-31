<?php

namespace App\Contracts\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;

interface ITemplateDeleteService
{
    public function __construct(ITemplateRepository $repository);

    public function delete(int $id) : ?bool;
}