<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentCreateRequest extends FormRequest
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
            'user_id' => 'integer|required|exists:users,id',
            'commentable_id' => 'integer|required|exists:documents,id',
            'commentable_type' => 'string|required|in:document',
            'parent_id' => 'nullable|integer|exists:comments,id',
            'body' => 'string|required|max:7999'
        ];
    }
}
