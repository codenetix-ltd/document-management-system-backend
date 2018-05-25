<?php

namespace App\Repositories;

use App\Entities\Label;

/**
 * Class DocumentRepositoryEloquent.
 */
class LabelRepositoryEloquent extends BaseRepository implements LabelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Label::class;
    }
}
