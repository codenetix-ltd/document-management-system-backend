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
     * @param $model
     * @param $scope
     * @return mixed
     */
    protected function applyJoin($model, $scope)
    {
        if ($scope === 'owner') {
            return $model->leftJoin('users as owner', 'logs.user_id', '=', 'owner.id');
        }

        return $model;
    }
}