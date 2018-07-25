<?php

namespace App\Criteria;

use App\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RelationSortingCriteria extends AbstractSortingCriteria
{
    
    /**
     * @param $orderBy
     * @param $sortedBy
     * @param Model|Builder $model
     *
     * @return mixed
     */
    function applySort($orderBy, $sortedBy, $model)
    {
        $split = explode('.', $orderBy);

        return count($split) > 1 ? $this->sortByRelation($split, $sortedBy, $model) : $model;
    }

    /**
     * @param $path
     * @param $sortedBy
     * @param BaseEntity| Builder $model
     *
     * @return Model|Builder
     */
    function sortByRelation($path, $sortedBy, $model) 
    {
        $field = array_pop($path);

        $lastModel = $model;

        foreach($path as $relationName) {
            if(isset($model->relationMap[$relationName])) {
                $relationName = $model->relationMap[$relationName];
            }
            if (!method_exists($lastModel, $relationName)) {
                //TODO throw exception?
                return $model->addSelect($model->getModel()->getTable().'.*');
            }

            /** @var Relation $relation */
            $relation = $lastModel->$relationName();
            /** @var BaseEntity $relationModel */
            $relationModel = $relation->getModel();
            $relationTable = $relationModel->getTable();
            $originalTable = $lastModel->getTable();
            $model = $this->addJoin($relationTable, $originalTable.'.'.snake_case($relationName).'_id', $model);

            $lastModel = $relationModel;
        }

        $sortingField = isset($lastModel->fieldMap[$field]) ? $lastModel->fieldMap[$field] : snake_case($field);

        $model = $model->addSelect($model->getModel()->getTable().'.*');

        return $sortingField ? $model->orderBy($lastModel->getTable().'.'.$sortingField, $sortedBy) : $model;
    }

    /**
     * @param $table
     * @param $foreignKey
     * @param Model|Builder $model
     * @return Builder
     */
    protected function addJoin($table, $foreignKey, $model)
    {
       return $model->leftJoin($table, $foreignKey, '=', $table.'.id');
    }
}
