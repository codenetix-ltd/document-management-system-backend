<?php

namespace App\Repositories;

use App\QueryParams\DocumentIdCriteria;
use App\QueryParams\IQueryParamsObject;
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

    public function latestVersionByDocumentId(int $documentId){
        return $this->getInstance()->where('document_id', $documentId)->orderBy('id', 'desc')->first();
    }
}
