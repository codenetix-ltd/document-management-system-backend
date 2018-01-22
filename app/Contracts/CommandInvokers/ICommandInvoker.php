<?php

namespace App\Contracts\CommandInvokers;

use App\Contracts\Commands\ICommand;

interface ICommandInvoker
{
    /**
     * @param ICommand $command
     * @return void
     */
    public function invoke(ICommand $command);
}