<?php

namespace App\Repositories;

use App\Entities\Template;

/**
 * Class DocumentRepositoryEloquent.
 */
class TemplateRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getInstance()
    {
        return new Template;
    }
}
