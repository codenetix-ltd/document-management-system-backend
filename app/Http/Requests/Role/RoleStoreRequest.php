<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\ABaseAPIRequest;

class RoleStoreRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('role_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'templatesIds' => 'array',
            'templatesIds.*' => 'integer|exists:templates,id',

            'permissionValues' => 'array'//TODO - add custom validation rule
        ];
    }
}
