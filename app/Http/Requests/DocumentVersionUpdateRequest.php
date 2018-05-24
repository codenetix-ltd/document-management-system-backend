<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentVersionUpdateRequest extends FormRequest
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
            'name' => 'string|required',

            'templateId' => 'integer|required',
            'templateIds.*' => 'integer',

            'labelIds' => 'array|required',
            'labelIds.*' => 'integer',

            'fileIds' => 'array|required',
            'fileIds.*' => 'integer',

            'comment' => 'string|required',

            'attributeValues' => 'array|required',
            'attributeValues.*.id' => 'required|integer',
            'attributeValues.*.type' => 'required|string',
            'attributeValues.*.value' => 'required',
        ];
    }
}
