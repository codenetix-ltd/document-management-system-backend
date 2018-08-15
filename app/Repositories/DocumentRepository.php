<?php

namespace App\Repositories;

use App\QueryParams\IQueryParamsObject;
use App\Entities\Document;
use App\QueryObject\DocumentListQueryObject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

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
     * @return LengthAwarePaginator
     */
    public function paginateList(IQueryParamsObject $queryParamsObject): LengthAwarePaginator
    {
        return (new DocumentListQueryObject($this->getQuery()))->applyQueryParams($queryParamsObject)->paginate();
    }
}
