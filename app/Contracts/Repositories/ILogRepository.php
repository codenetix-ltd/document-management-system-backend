<?php

namespace App\Contracts\Repositories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface ILogRepository extends RepositoryInterface
{
    public function list($userId = null): LengthAwarePaginator;
}
