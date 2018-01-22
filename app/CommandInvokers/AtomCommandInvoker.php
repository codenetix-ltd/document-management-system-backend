<?php

namespace App\CommandInvokers;

use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\Commands\ICommand;

class AtomCommandInvoker implements IAtomCommandInvoker
{
    public function invoke(ICommand $command)
    {
        $command->execute();
    }
}