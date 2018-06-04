<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
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
            'createNewVersion' => 'boolean|required',
            'ownerId' => 'integer|required',
            'substituteDocumentId' => 'integer',

            'actualVersion' => 'array|required',

            'actualVersion.name' => 'string|required',

            'actualVersion.templateId' =>  'integer|required|exists:templates,id',

            'actualVersion.labelIds' => 'array|present',
            'actualVersion.labelIds.*' => 'integer|exists:labels,id',

            'actualVersion.fileIds' => 'array|present',
            'actualVersion.fileIds.*' => 'integer|exists:files,id',

            'actualVersion.comment' => 'string|present',

            'actualVersion.attributeValues' => 'array|present',
            'actualVersion.attributeValues.*.id' => 'required|integer|exists:attributes,id',
            'actualVersion.attributeValues.*.type' => 'required|string|exists:types,machine_name',
            'actualVersion.attributeValues.*.value' => 'required',
        ];
    }
}
