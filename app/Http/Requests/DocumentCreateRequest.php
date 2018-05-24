<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentCreateRequest extends FormRequest
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
            'ownerId' => 'integer|required',
            'substituteDocumentId' => 'integer',

            'actualVersion' => 'array|required',

            'actualVersion.name' => 'string|required',

            'actualVersion.templateId' => 'integer|required',
            'actualVersion.templateIds.*' => 'integer',

            'actualVersion.labelIds' => 'array|required',
            'actualVersion.labelIds.*' => 'integer',

            'actualVersion.fileIds' => 'array|required',
            'actualVersion.fileIds.*' => 'integer',

            'actualVersion.comment' => 'string|required',

            'actualVersion.attributeValues' => 'array|required',
            'actualVersion.attributeValues.*.id' => 'required|integer',
            'actualVersion.attributeValues.*.type' => 'required|string',
            'actualVersion.attributeValues.*.value' => 'required',
        ];
    }
}
