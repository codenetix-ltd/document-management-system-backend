<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\ABaseAPIRequest;

class RoleUpdateRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('role_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|unique:roles,name,'.$this->route('role'),
            'templatesIds' => 'array',
            'templatesIds.*' => 'integer|exists:templates,id',

            //TODO rules for permissionValues.*
            'permissionValues' => 'array'
        ];
    }
}
