<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface as Base;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface RepositoryInterface extends Base
{
    /**
     * @deprecated
     *
     * Use @see paginateList
     */
    public function paginate($limit = null, $columns = ['*']);

    /**
     * @param $withCriteria
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginateList($withCriteria, $limit = null,  $columns = ['*']);
}
