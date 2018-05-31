<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DocumentRepository.
 */
interface DocumentRepository extends RepositoryInterface
{
    public function findModel($id);
}
