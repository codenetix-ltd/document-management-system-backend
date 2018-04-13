<?php

namespace App\Repositories;

use App\Contracts\Repositories\ITemplateRepository;
use App\Template;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TemplateRepository implements ITemplateRepository
{
    public function create(Template $template): Template
    {
        $template->save();

        return $template;
    }

    public function findOrFail(int $id): Template
    {
        return Template::findOrFail($id);
    }

    public function update(int $id, Template $templateInput, array $updatedFields): Template
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