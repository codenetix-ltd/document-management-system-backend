<?php

namespace App\Repositories;

use App\Entities\Type;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TypeRepository.
 */
interface TypeRepository extends RepositoryInterface
{
    /**
     * @param string $machineName
     * @return Type
     */
    public function getTypeByMachineName(string $machineName): Type;
}
