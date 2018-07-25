<?php

namespace App\Repositories;

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
