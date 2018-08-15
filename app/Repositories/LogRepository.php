<?php

namespace App\Repositories;

use App\QueryParams\IQueryParamsObject;
use App\Entities\Log;
use App\QueryObject\LogListQueryObject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class LogRepository extends BaseRepository
{

    /**
     * @return Model
     */
    protected function getInstance(): Model
    {
        return new Log();
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return LengthAwarePaginator
     */
    public function paginateList(IQueryParamsObject $queryParamsObject): LengthAwarePaginator
    {
        return (new LogListQueryObject($this->getInstance()->newQuery()))->applyQueryParams($queryParamsObject)->paginate();
    }
}
