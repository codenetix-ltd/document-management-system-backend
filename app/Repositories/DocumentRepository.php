<?php

namespace App\Repositories;

use App\QueryParams\IQueryParamsObject;
use App\Entities\Document;
use App\QueryObject\DocumentListQueryObject;

class DocumentRepository extends BaseRepository
{

    /**
     * @return Document|mixed
     */
    protected function getInstance()
    {
        return new Document();
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return null
     */
    public function paginateList(IQueryParamsObject $queryParamsObject)
    {
        return (new DocumentListQueryObject($this->getQuery()))->applyQueryParams($queryParamsObject)->paginate();
    }
}
