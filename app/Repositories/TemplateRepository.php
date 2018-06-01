<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TemplateRepository.
 */
interface TemplateRepository extends RepositoryInterface
{
    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id);
}
