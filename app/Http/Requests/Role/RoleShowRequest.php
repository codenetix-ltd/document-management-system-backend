<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\AttributeService;
use App\Services\LabelService;
use App\Services\RoleService;
use Illuminate\Database\Eloquent\Model;

class RoleShowRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('role_view');
    }

    /**
     * @param RoleService $roleService
     * @return mixed
     */
    public function getTargetModel(RoleService $roleService): Model
    {
         return $roleService->find($this->route()->parameter('role'));
    }
}
