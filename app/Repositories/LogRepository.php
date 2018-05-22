<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LogRepository.
 */
interface LogRepository extends RepositoryInterface
{
    public function paginateByUser($userId);
}
