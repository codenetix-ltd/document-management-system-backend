<?php

namespace App\Repositories;

use App\Criteria\DocumentIdCriteria;
use App\Criteria\IQueryParamsObject;
use App\Entities\DocumentVersion;
use App\QueryObject\DocumentListQueryObject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;


class DocumentVersionRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    protected function getInstance()
    {
        return new DocumentVersion;
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @param integer $documentId
     * @return LengthAwarePaginator
     */
    public function paginateByDocumentId(IQueryParamsObject $queryParamsObject, int $documentId): LengthAwarePaginator
    {
        return $this->getInstance()->where('document_id', $documentId)->paginate();
    }
}
