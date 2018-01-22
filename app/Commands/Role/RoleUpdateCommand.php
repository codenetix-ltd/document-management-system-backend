<?php

namespace App\Commands\Role;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Role\IRoleUpdateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IRole;
use App\Exceptions\CommandException;
use App\Role;
use Exception;

class RoleUpdateCommand extends ACommand implements IRoleUpdateCommand
{
    /** @var int $id */
    private $id;

    private $role;

    /** @var array $inputData */
    private $inputData;

    /**
     * RoleUpdateCommand constructor.
     * @param \Illuminate\Contracts\Container\Container $id
     * @param array $inputData
     */
    public function __construct($id, array $inputData)
    {
        $this->id = $id;
        $this->inputData = $inputData;
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
        $role = Role::findOrFail($this->id);
        $role->fill($this->inputData);
        $role->name = snake_case($role->label);
        $role->save();

        $role->factories()->sync(array_get($this->inputData , 'factory_id', []));
        $role->templates()->sync(array_get($this->inputData , 'template_id', []));

        $this->role = $role;

        $this->executed = true;
    }
}
