<?php

namespace App\Repositories;

/**
 * Interface DocumentVersionRepository.
 */
interface DocumentVersionRepository extends RepositoryInterface
{
    /**
     * @param integer $documentId
     * @param bool $withCriteria
     * @return mixed
     */
    public function paginateByDocument(int $documentId, $withCriteria = false);

    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id);
}
