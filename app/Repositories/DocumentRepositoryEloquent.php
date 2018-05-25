<?php

namespace App\Repositories;

use App\Criteria\DocumentFilterCriteria;
use App\Entities\Document;

/**
 * Class DocumentRepositoryEloquent.
 */
class DocumentRepositoryEloquent extends BaseRepository implements DocumentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Document::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        parent::boot();
        $this->pushCriteria(app(DocumentFilterCriteria::class));
    }
}
