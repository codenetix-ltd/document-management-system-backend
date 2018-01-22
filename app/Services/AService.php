<?php

namespace App\Services;

use App\Contracts\Commands\ICommand;
use App\Exceptions\CommandException;
use Illuminate\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class AService implements ICommand
{
    /** @var bool $executed */
    protected $executed = false;

    /** @var Container $container */
    protected $container;

    /**
     * AService constructor.
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