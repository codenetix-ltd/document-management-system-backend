<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentCreateRequest extends FormRequest
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
            'ownerId' => 'integer|required',
            'substituteDocumentId' => 'nullable|integer',

            'actualVersion' => 'array|required',

            'actualVersion.name' => 'string|required',

            'actualVersion.templateId' => 'integer|required|exists:templates,id',

            'actualVersion.labelIds' => 'sometimes|array',
            'actualVersion.labelIds.*' => 'integer|exists:labels,id',

            'actualVersion.fileIds' => 'sometimes|array',
            'actualVersion.fileIds.*' => 'integer|exists:files,id',

            'actualVersion.comment' => 'sometimes|string',

            'actualVersion.attributeValues' => 'sometimes|array',
            'actualVersion.attributeValues.*.id' => 'required|integer|exists:attributes,id',
            'actualVersion.attributeValues.*.type' => 'required|string|exists:types,machine_name',
            'actualVersion.attributeValues.*.value' => 'required',
        ];
    }
}
