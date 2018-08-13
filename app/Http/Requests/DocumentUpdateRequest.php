<?php

namespace App\Http\Requests;

use App\Context\DocumentAuthorizeContext;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;

class DocumentUpdateRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('document_update');
    }

    /**
     * @return DocumentAuthorizer
     */
    protected function getAuthorizer(){
        return new DocumentAuthorizer(new DocumentAuthorizeContext(Auth::user(), $this->model()));
    }

    /**
     * @param DocumentService $documentService
     * @return mixed
     */
    public function getTargetModel(DocumentService $documentService)
    {
        return $documentService->find($this->route()->parameter('id'));
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
            'substituteDocumentId' => 'nullable|integer',

            'actualVersion' => 'array|required',

            'actualVersion.name' => 'string|required',

            'actualVersion.templateId' =>  'integer|required|exists:templates,id',

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
