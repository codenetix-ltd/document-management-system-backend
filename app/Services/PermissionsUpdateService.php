<?php

namespace App\Services;

use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasId;
use App\Contracts\Exceptions\ICommandException;
use App\Entity\Permissions\PermissionAccessTypeValue;
use App\Role;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;

class PermissionsUpdateService extends ACommand
{
    private $permissionAccessTypeValues;
    private $role;

    /**
     * PermissionsUpdateService constructor.
     * @param Container $container
     * @param IHasId $role
     * @param Collection $permissionAccessTypeValues
     */
    public function __construct(Container $container, IHasId $role, Collection $permissionAccessTypeValues)
    {
        parent::__construct($container);
        $this->permissionAccessTypeValues = $permissionAccessTypeValues;
        $this->role = $role;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $permissionsPlain = [];
        $qualifiersByPermissionId = [];

        /**
         * @var PermissionAccessTypeValue $permissionAccessTypeValue
         */
        foreach ($this->permissionAccessTypeValues as $permissionAccessTypeValue) {
            $permissionsPlain[$permissionAccessTypeValue->getPermissionId()] = ['access_type' => $permissionAccessTypeValue->getAccessTypeId()];
            if ($qualifiers = $permissionAccessTypeValue->getQualifiers()) {
                $plainQualifiers = [];
                foreach ($qualifiers as $qualifier){
                    $plainQualifiers[$qualifier->getId()] = ['access_type' => $qualifier->getAccessType()];
                }
                $qualifiersByPermissionId[$permissionAccessTypeValue->getPermissionId()] = $plainQualifiers;
            }
        }

        $roleModel = Role::findOrFail($this->role->getId());
        $roleModel->permissions()->sync($permissionsPlain);

        foreach ($roleModel->permissions as $permission) {
            if (isset($qualifiersByPermissionId[$permission->id])) {
                $permission->pivot->qualifiers()->sync($qualifiersByPermissionId[$permission->id]);
            } else {
                $permission->pivot->qualifiers()->sync([]);
            }
        }

    }
}