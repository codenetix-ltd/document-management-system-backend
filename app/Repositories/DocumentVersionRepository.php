<?php

namespace App\Repositories;

use App\Criteria\DocumentIdCriteria;
use App\Criteria\IQueryParamsObject;
use App\Entities\DocumentVersion;
use App\QueryObject\DocumentListQueryObject;
use Prettus\Repository\Exceptions\RepositoryException;


class DocumentVersionRepository extends BaseRepository
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
     * @return mixed
     */
    protected function getInstance()
    {
        return new DocumentVersion;
    }
}
