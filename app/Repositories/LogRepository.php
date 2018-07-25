<?php

namespace App\Repositories;

/**
 * Interface LogRepository.
 */
interface LogRepository extends RepositoryInterface
{
    /**
     * @param integer $userId
     * @param bool $withCriteria
     * @return mixed
     */
    public function paginateByUser(int $userId, $withCriteria = false);
}
