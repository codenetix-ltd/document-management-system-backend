<?php

namespace App\Http\Requests\DocumentVersion;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;

class DocumentVersionStoreRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('document_update');
    }

    /**
     * @return DocumentAuthorizer
     */
    protected function getAuthorizer()
    {
        $documentService = $this->container->make(DocumentService::class);
        return new DocumentAuthorizer(new DocumentAuthorizeContext(Auth::user(), $documentService->find($this->get('documentId', null))));
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
            'documentId' => 'integer|required|exists:documents,id',
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
