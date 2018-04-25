<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface RepositoryInterface
{
    public function save(Model $model): int;
    public function delete(Model $model): ?bool;
}
