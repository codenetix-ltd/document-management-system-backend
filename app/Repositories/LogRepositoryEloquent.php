<?php

namespace App\Repositories;

use App\Criteria\RelationSortingCriteria;
use App\Criteria\UserIdCriteria;
use App\Entities\Log;

/**
 * Class DocumentRepositoryEloquent.
 */
class LogRepositoryEloquent extends BaseRepository implements LogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Log::class;
    }

    /**
     * @param integer $userId
     *
     * @param bool $withCriteria
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function paginateByUser(int $userId, $withCriteria = false)
    {
        $this->pushCriteria(new UserIdCriteria($userId));
        return $this->paginateList($withCriteria);
    }

    public function getCriteriaList()
    {
        return [
            app(RelationSortingCriteria::class),
        ];
    }
}
