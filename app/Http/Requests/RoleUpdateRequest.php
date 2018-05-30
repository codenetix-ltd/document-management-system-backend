<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
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
            'templateIds' => 'array',
            'templatesIds.*' => 'integer|exists:templates,id',

            //TODO rules for permissionValues.*
            'permissionValues' => 'array'
        ];
    }
}
