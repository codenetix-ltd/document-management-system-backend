<?php

namespace App\Repositories;

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
