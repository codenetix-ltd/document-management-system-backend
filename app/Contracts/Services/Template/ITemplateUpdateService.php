<?php

namespace App\Contracts\Services\Template;

use App\Template;

interface ITemplateUpdateService
{
    public function update(int $id, Template $templateInput, array $updatedFields) : Template;
}