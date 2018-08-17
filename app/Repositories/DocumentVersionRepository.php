<?php

namespace App\Repositories;

use App\QueryParams\DocumentIdCriteria;
use App\QueryParams\IQueryParamsObject;
use App\Entities\DocumentVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class DocumentVersionRepository extends BaseRepository
{
    /**
     * @return Model
     */
    protected function getInstance(): Model
    {
        return new DocumentVersion;
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @param integer            $documentId
     * @return LengthAwarePaginator
     */
    public function paginateByDocumentId(IQueryParamsObject $queryParamsObject, int $documentId): LengthAwarePaginator
    {
        return $this->getInstance()->where('document_id', $documentId)->paginate();
    }

    /**
     * @param integer $documentId
     * @return Model|null
     */
    public function latestVersionByDocumentId(int $documentId): ?Model
    {
        return $this->getInstance()->where('document_id', $documentId)->orderBy('id', 'desc')->first();
    }
}
