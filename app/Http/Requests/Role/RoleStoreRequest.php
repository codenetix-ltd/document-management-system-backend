<?php

namespace App\Http\Requests\Role;

class RoleStoreRequest extends RoleBaseRequest
{
    //TODO - write custom validator for permissionValues
    protected $modelConfigName = 'RoleRequest';
}
