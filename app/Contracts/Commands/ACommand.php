<?php

namespace App\Contracts\Commands;

use App\Exceptions\CommandException;
use Illuminate\Contracts\Container\Container;

abstract class ACommand implements ICommand
{
    /** @var bool $executed */
    protected $executed = false;

    /** @var Container $container */
    protected $container;

    /**
     * ACommand constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws CommandException
     * @return void
     */
    protected function isExecuted()
    {
        if (!$this->executed) {
            throw new CommandException('Command not executed!');
        }
    }
}