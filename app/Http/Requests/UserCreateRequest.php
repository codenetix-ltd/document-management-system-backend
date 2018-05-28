<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'password' => 'required|string|max:255|min:6',
            'passwordConfirmation' => 'required|same:password',
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'templatesIds' => 'required|array',
            'templatesIds.*' => 'integer|exists:templates,id',
            'avatarId' => 'required|integer|exists:files,id'
        ];
    }
}
