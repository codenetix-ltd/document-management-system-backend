<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\AttributeService;
use App\Services\LabelService;
use App\Services\RoleService;

class RoleShowRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('role_view');
    }

    /**
     * @param RoleService $roleService
     * @return mixed
     */
    public function getTargetModel(RoleService $roleService)
    {
         return $roleService->find($this->route()->parameter('role'));
    }
}
