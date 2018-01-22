<?php

namespace App\Commands\Role;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Role\IRoleCreateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IRole;
use App\Permission;
use App\PermissionGroup;
use App\Role;

class RoleCreateCommand extends ACommand implements IRoleCreateCommand
{
    /**
     * @var IRole
     */
    private $role;

    /**
     * @var array
     */
    private $inputData;

    /**
     * RoleCreateCommand constructor.
     * @param array $inputData
     */
    public function __construct(array $inputData)
    {
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
        $role = new Role();
        $role->fill($this->inputData);
        $role->name = snake_case($role->label);
        $role->save();
        $this->role = $role;

        $role->factories()->sync(array_get($this->inputData , 'factory_id', []));
        $role->templates()->sync(array_get($this->inputData , 'template_id', []));

        $role->permissions()->sync(Permission::all());
        $this->executed = true;
    }
}
