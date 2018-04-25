<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepositoryInterface;
use App\Entity\Document;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class EloquentRepository implements RepositoryInterface
{
    public function save(Model $model): int
    {
        $model->save();

        return $model->id;
    }

    /**
     * @param Model $model
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }
}
