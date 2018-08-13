<?php

namespace App\Repositories;

use App\Criteria\IQueryParamsObject;
use App\Entities\Log;
use App\QueryObject\LogListQueryObject;

class LogRepository extends BaseRepository
{
    protected function getInstance()
    {
        return new Log();
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateList(IQueryParamsObject $queryParamsObject){
        return (new LogListQueryObject($this->getInstance()->newQuery()))->applyQueryParams($queryParamsObject)->paginate();
    }
}
