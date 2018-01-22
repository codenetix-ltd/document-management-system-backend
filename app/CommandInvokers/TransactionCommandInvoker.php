<?php

namespace App\CommandInvokers;

use App\Contracts\CommandInvokers\ITransactionCommandInvoker;
use App\Contracts\Commands\ICommand;
use Illuminate\Support\Facades\DB;

class TransactionCommandInvoker implements ITransactionCommandInvoker
{
    public function invoke(ICommand $command)
    {
        DB::transaction(function() use ($command) {
            $command->execute();
        });
    }
}