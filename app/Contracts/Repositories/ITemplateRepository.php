<?php

namespace App\Contracts\Repositories;

use App\Template;

interface ITemplateRepository extends IRepository
{
    public function create(Template $template) : Template;

    public function findOrFail(int $id) : Template;

    public function update(int $id, Template $templateInput, array $updatedFields): Template;

    public function delete(int $id): ?bool;
}