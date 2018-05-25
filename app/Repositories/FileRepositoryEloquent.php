<?php

namespace App\Repositories;

use App\Entities\File;

/**
 * Class DocumentRepositoryEloquent.
 */
class FileRepositoryEloquent extends BaseRepository implements FileRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return File::class;
    }
}
