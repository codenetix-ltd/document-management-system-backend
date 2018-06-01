<?php

namespace App\Repositories;

use App\Criteria\DocumentIdCriteria;
use App\Entities\DocumentVersion;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class DocumentRepositoryEloquent.
 */
class DocumentVersionRepositoryEloquent extends BaseRepository implements DocumentVersionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DocumentVersion::class;
    }

    /**
     * @param integer $documentId
     * @return mixed
     * @throws RepositoryException
     */
    public function paginateByDocument(int $documentId)
    {
        $this->pushCriteria(new DocumentIdCriteria($documentId));
        return $this->paginate();
    }
}
