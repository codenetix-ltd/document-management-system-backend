<?php

namespace App\Repositories;

use App\Criteria\ExtendedRequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    /**
     * @throws RepositoryException
     */
    public function boot()
    {
        parent::boot();

        $this->pushCriteria(app(ExtendedRequestCriteria::class));
    }

    public function findModel($id)
    {
        return $this->model->find($id);
    }
}
