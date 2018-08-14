<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\ABaseAPIRequest;

class RoleStoreRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('role_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'templatesIds' => 'array',
            'templatesIds.*' => 'integer|exists:templates,id',

            'permissionValues' => 'array'//TODO - add custom validation rule
        ];
    }
}
