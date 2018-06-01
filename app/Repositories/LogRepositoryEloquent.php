<?php

namespace App\Repositories;

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
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function paginateByUser(int $userId)
    {
        $this->pushCriteria(new UserIdCriteria($userId));
        return $this->paginate();
    }
}
