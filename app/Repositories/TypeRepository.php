<?php

namespace App\Repositories;

use App\Entities\Type;

/**
 * Interface TypeRepository.
 */
class TypeRepository extends BaseRepository
{

    /**
     * @param string $machineName
     * @return Type
     */
    public function getTypeByMachineName(string $machineName): Type
    {
        return $this->getInstance()->where('machine_name', '=', $machineName)->first();
    }

    /**
     * @return mixed
     */
    protected function getInstance()
    {
        return new Type();
    }
}
