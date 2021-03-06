<?php

namespace App\Http\Requests\Tag;

class TagStoreRequest extends TagBaseRequest
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
            'name' => 'required|unique:tags|max:255'
        ];
    }

    public function getModelStructure(): array
    {
        return config('models.tag_store_request');
    }
}
