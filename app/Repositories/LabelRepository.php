<?php

namespace App\Repositories;

use App\Entities\Label;

/**
 * Class DocumentRepositoryEloquent.
 */
class LabelRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getInstance()
    {
        return new Label();
    }
}
