<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\ITemplate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

interface ITemplateRepository
{
    public function create(ITemplate $template) : ITemplate;

    public function findOrFail(int $id) : ITemplate;

    public function update(int $id, ITemplate $templateInput, array $updatedFields): ITemplate;

    public function delete(int $id): ?bool;

    public function list(): LengthAwarePaginatorContract;
}