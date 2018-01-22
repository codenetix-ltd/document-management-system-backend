<?php

namespace App\Contracts\Commands;

use App\Contracts\Exceptions\ICommandException;

interface ICommand
{
    /**
     * @throws ICommandException
     * @return void
     */
    public function execute();
}