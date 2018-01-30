<?php

namespace App\Repositories;

use App\Contracts\Models\ITemplate;
use App\Contracts\Repositories\ITemplateRepository;
use App\Template;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TemplateRepository implements ITemplateRepository
{
    public function create(ITemplate $template): ITemplate
    {
        $template->save();

        return $template;
    }

    public function findOrFail(int $id): ITemplate
    {
        return Template::findOrFail($id);
    }

    public function update(int $id, ITemplate $templateInput, array $updatedFields): ITemplate
    {
        $template = Template::findOrFail($id);

        foreach ($updatedFields as $fieldKey) {
            $template->{dms_build_setter($fieldKey)}($templateInput->{dms_build_getter($fieldKey)}());
        }

        $template->save();

        return $template;
    }

    public function delete(int $id): ?bool
    {
        return Template::where('id', $id)->delete();
    }

    public function list(): LengthAwarePaginatorContract
    {
        return Template::paginate();
    }
}