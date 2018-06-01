<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DocumentRepository.
 */
interface DocumentRepository extends RepositoryInterface
{
    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id);
}
