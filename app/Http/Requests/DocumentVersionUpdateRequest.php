<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentVersionUpdateRequest extends FormRequest
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
            'name' => 'string|required',

            'templateId' => 'integer|required|exists:templates,id',

            'labelIds' => 'array|required',
            'labelIds.*' => 'integer|exists:labels,id',

            'fileIds' => 'array|required',
            'fileIds.*' => 'integer|exists:files,id',

            'comment' => 'string|required',

            'attributeValues' => 'array|required',
            'attributeValues.*.id' => 'required|integer|exists:attributes,id',
            'attributeValues.*.type' => 'required|string|exists:types,machine_name',
            'attributeValues.*.value' => 'required',
        ];
    }
}
