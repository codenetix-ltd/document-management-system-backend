<?php

namespace App\Repositories;

use App\Criteria\ExtendedRequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    /**
     * @throws RepositoryException
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->pushCriteria(app(ExtendedRequestCriteria::class));
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id)
    {
        return $this->model->find($id);
    }
}
