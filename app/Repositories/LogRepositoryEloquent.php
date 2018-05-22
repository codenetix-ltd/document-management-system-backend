<?php

namespace App\Repositories;

use App\Criteria\UserIdCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
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
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function paginateByUser($userId)
    {
        $this->pushCriteria(new UserIdCriteria($userId));
        return $this->paginate();
    }
}
