<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

trait TransactionTrait
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