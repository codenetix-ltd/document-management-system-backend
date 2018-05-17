<?php

namespace App\Repositories;

use App\Entities\Type;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TypeRepository.
 */
interface TypeRepository extends RepositoryInterface
{
    public function getTypeByMachineName($machineName): Type;
}
