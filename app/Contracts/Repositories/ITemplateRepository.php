<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\ITemplate;

interface ITemplateRepository extends IRepository
{
    public function create(ITemplate $template) : ITemplate;

    public function findOrFail(int $id) : ITemplate;

    public function update(int $id, ITemplate $templateInput, array $updatedFields): ITemplate;

    public function delete(int $id): ?bool;
}