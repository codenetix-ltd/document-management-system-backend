<?php

namespace App\Repositories;

use App\Entities\Type;

/**
 * Class DocumentRepositoryEloquent.
 */
class TypeRepositoryEloquent extends BaseRepository implements TypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Type::class;
    }

    public function getTypeByMachineName($machineName): Type
    {
        return $this->findWhere([
            ['machine_name', '=', $machineName]
        ])->first();
    }
}
