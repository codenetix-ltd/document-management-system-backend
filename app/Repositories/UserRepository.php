<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id);
}
