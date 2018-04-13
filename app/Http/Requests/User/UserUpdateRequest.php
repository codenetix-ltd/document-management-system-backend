<?php

namespace App\Http\Requests\User;

class UserUpdateRequest extends UserBaseRequest
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
            'fullName' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email',
            'templatesIds' => 'array',
            'password' => 'sometimes|required|min:6',
            'passwordConfirmation' => 'sometimes|required|same:password',
            'avatar' => 'image'
        ];
    }
}
