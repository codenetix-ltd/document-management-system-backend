<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentCreateRequest extends FormRequest
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
            'user_id' => 'integer|required',
            'commentable_id' => 'integer|required',
            'commentable_type' => 'string|required',
            'parent_id' => 'nullable',
            'body' => 'string|required|max:255'
        ];
    }
}
