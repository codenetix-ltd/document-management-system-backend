<?php

namespace App\Repositories;

use App\Criteria\LogFilterCriteria;
use App\Criteria\UserIdCriteria;
use App\Entities\Log;
use Prettus\Repository\Exceptions\RepositoryException;

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

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->pushCriteria(app(LogFilterCriteria::class));
    }
}
