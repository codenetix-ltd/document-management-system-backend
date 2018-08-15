<?php

namespace App\Http\Requests\Document;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DocumentUpdateRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('document_update');
    }

    /**
     * @return AAuthorizer
     */
    protected function getAuthorizer(): AAuthorizer
    {
        return new DocumentAuthorizer(new DocumentAuthorizeContext(Auth::user(), $this->model()));
    }

    /**
     * @param DocumentService $documentService
     * @return Model
     */
    public function getTargetModel(DocumentService $documentService): Model
    {
        return $documentService->find($this->route()->parameter('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
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
