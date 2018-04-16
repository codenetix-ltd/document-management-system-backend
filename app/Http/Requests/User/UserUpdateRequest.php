<?php

namespace App\Http\Requests\User;

class UserUpdateRequest extends UserBaseRequest
{
    protected $modelConfigName = 'UserPostRequest';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullName' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email',
            'templatesIds' => 'array',
            'password' => 'sometimes|required|min:6',
            'passwordConfirmation' => 'sometimes|required|same:password',
            'avatar' => 'image'
        ];
    }
}
