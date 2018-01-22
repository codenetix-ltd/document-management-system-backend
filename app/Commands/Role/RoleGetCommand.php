<?php

namespace App\Commands\Role;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Role\IRoleGetCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IRole;
use App\Exceptions\CommandException;
use App\Role;
use Exception;

class RoleGetCommand extends ACommand implements IRoleGetCommand
{
    /** @var int $id */
    private $id;

    /** @var IRole $role */
    private $role;

    /**
     * RoleGetCommand constructor.
     * @param \Illuminate\Contracts\Container\Container $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getResult() : IRole
    {
        $this->isExecuted();

        return $this->role;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $this->role = Role::findOrFail($this->id);
        } catch (Exception $e){
            throw new CommandException('Role Not Found');
        }

        $this->executed = true;
    }
}