<?php

namespace App\Http\Requests\User;

class UserStoreRequest extends UserBaseRequest
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
            'fullName' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'templatesIds' => 'array',
            'password' => 'required|min:6',
            'passwordConfirmation' => 'required|same:password',
            'avatar' => 'image'
        ];
    }

    public function getModelStructure(): array
    {
        return config('models.user_store_request');
    }
}
