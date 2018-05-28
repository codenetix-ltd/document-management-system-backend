<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentPatchUpdateRequest extends FormRequest
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
            'ownerId' => 'integer|exists:users,id',
            'substituteDocumentId' => 'integer|exists:documents,id',
            'actualVersionId' => 'integer|exists:document_versions,id'
        ];
    }
}
