<?php

namespace App\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserIdCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserIdCriteria implements CriteriaInterface
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder       $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('user_id', '=', $this->userId);
        return $model;
    }
}
