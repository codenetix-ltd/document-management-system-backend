<?php

namespace App\Repositories;

use App\QueryParams\IQueryParamsObject;
use App\Entities\Log;
use App\QueryObject\LogListQueryObject;
use Carbon\Carbon;
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

    /**
     * @param int $userId
     * @param Carbon $date
     * @return mixed
     */
    public function getActionsTotalByUserIdAndDate(int $userId, Carbon $date): int {
        return $this->getInstance()->where('user_id', $userId)->whereDate('created_at', $date)->count();
    }

    /**
     * @param Carbon $date
     * @return mixed
     */
    public function getActionsTotalByDate(Carbon $date): int {
        return $this->getInstance()->whereDate('created_at', $date)->count();
    }
}
