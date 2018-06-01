<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LogRepository.
 */
interface LogRepository extends RepositoryInterface
{
    /**
     * @param integer $userId
     * @return mixed
     */
    public function paginateByUser(int $userId);
}
