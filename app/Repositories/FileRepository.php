<?php

namespace App\Repositories;

use App\Entities\File;

/**
 * Class DocumentRepositoryEloquent.
 */
class FileRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    protected function getInstance()
    {
        return new File();
    }
}
