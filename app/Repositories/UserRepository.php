<?php

namespace App\Repositories;

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
