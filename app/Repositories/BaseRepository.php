<?php

namespace App\Repositories;

use App\Criteria\SimpleSortingCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository implements RepositoryInterface
{
    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param bool $withCriteria
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function paginateList($withCriteria = false, $limit = null, $columns = ['*'])
    {
        if ($withCriteria) {
            foreach ($this->getFullCriteriaList() as $criteria) {
                $this->pushCriteria($criteria);
            }
        }

        return $this->paginate($limit, $columns);
    }

    /**
     * @return CriteriaInterface[]
     */
    protected function getCriteriaList()
    {
        return [];
    }

    private function getFullCriteriaList()
    {
        return array_merge([
            app(SimpleSortingCriteria::class),
        ], $this->getCriteriaList());
    }
}
