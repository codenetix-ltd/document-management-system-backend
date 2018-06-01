<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LabelRepository.
 */
interface LabelRepository extends RepositoryInterface
{
    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id);
}
