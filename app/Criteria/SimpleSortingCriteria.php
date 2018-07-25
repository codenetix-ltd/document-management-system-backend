<?php

namespace App\Criteria;

use App\Entities\BaseEntity;
use Illuminate\Database\Query\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class SimpleSortingCriteria extends AbstractSortingCriteria
{
    /**
     * @param $orderBy
     * @param $sortedBy
     * @param BaseEntity|Builder $model
     *
     * @return mixed
     */
    function applySort($orderBy, $sortedBy, $model)
    {
        if(!$orderBy) {
            return $model;
        }

        $split = explode('.', $orderBy);

        if (count($split) > 1) {
            return $model;
        } else {
            $orderField = isset ($model->fieldMap[$orderBy]) ? $model->fieldMap[$orderBy] : snake_case($orderBy);
            
            if (!$orderField) {
                return $model;
            }
            
            return $model->orderBy(
                $orderField,
                $sortedBy
            );
        }
    }
}
