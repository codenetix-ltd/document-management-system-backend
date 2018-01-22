<?php

namespace App\Commands\Role;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Role\IRoleListCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Role;

class RoleListCommand extends ACommand implements IRoleListCommand
{
    /** @var array $columns */
    private $columns;

    /** @var array $roles */
    private $roles;

    public function __construct($columns = ['*'])
    {
        $this->columns = $columns;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->roles;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $this->roles = Role::all($this->columns);

        $this->executed = true;
    }
}
