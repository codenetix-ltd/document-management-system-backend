<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DocumentVersionRepository.
 */
interface DocumentVersionRepository extends RepositoryInterface
{
    public function paginateByDocument($documentId);
    public function findModel($id);
}
