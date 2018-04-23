<?php

namespace App\Repositories;

use App\Contracts\Services\ITransaction;
use Illuminate\Support\Facades\DB;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DBTransaction implements ITransaction
{
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    public function rollback()
    {
        DB::rollBack();
    }

    public function commit()
    {
        DB::commit();
    }
}
