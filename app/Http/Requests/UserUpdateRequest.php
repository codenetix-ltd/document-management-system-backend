<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->route('user'),
            'templatesIds' => 'sometimes|array',
            'templatesIds.*' => 'integer|exists:templates,id',
            'avatarId' => 'sometimes|integer|exists:files,id'
        ];
    }
}
