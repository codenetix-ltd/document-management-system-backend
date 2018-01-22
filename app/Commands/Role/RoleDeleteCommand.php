<?php

namespace App\Commands\Role;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Role\IRoleDeleteCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Exceptions\CommandException;
use App\Role;
use Exception;

class RoleDeleteCommand extends ACommand implements IRoleDeleteCommand
{
    /** @var int $id */
    private $id;

    /**
     * RoleDeleteCommand constructor.
     * @param \Illuminate\Contracts\Container\Container $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $role = Role::findOrFail($this->id);
            $role->delete();
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
