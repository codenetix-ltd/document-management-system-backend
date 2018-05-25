<?php

namespace App\Repositories;

use App\Entities\Template;

/**
 * Class DocumentRepositoryEloquent.
 */
class TemplateRepositoryEloquent extends BaseRepository implements TemplateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Template::class;
    }
}
