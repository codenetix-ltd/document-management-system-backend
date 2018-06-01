<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DocumentVersionRepository.
 */
interface DocumentVersionRepository extends RepositoryInterface
{
    /**
     * @param integer $documentId
     * @return mixed
     */
    public function paginateByDocument(int $documentId);

    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id);
}
