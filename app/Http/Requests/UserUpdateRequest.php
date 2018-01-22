<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'full_name' => 'bail|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email',
            'factory_id' => 'required|exists:factories,id',
            'template_id' => 'required|exists:templates,id',
            //'roles' => 'required|exists:factories,id', TODO - add validation
            'password' => 'sometimes|min:6|confirmed|nullable',
            'file' => 'image'
        ];
    }
}
