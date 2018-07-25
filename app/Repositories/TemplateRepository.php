<?php

namespace App\Repositories;

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
