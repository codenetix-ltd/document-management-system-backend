<?php

namespace App\Http\Requests\User;

class UserStoreRequest extends UserBaseRequest
{
    protected $modelConfigName = 'UserPostRequest';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
//    public function rules()
//    {
//        return [
//            'fullName' => 'required|max:255',
//            'email' => 'required|email|unique:users,email',
//            'templatesIds' => 'array',
//            'password' => 'required|min:6',
//            'passwordConfirmation' => 'required|same:password',
//            'avatar' => 'image'
//        ];
//    }
}
