<?php /** @noinspection ALL */

namespace App\QueryObject;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class LogListQueryObject extends AQueryObject
{

    /**
     * @return array
     */
    protected function map()
    {
        return [
            'user.fullName' => 'owner.full_name'
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $model
     * @param string                                                                    $scope
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Builder
     */
    protected function applyJoin($model, string $scope)
    {
        if ($scope === 'owner') {
            return $model->leftJoin('users as owner', 'logs.user_id', '=', 'owner.id');
        }

        return $model;
    }
}
