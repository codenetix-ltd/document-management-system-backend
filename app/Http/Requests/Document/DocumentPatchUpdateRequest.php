<?php

namespace App\Http\Requests\Document;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;

class DocumentPatchUpdateRequest extends ABaseAPIRequest
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
            'ownerId' => 'integer|exists:users,id',
            'substituteDocumentId' => 'integer|exists:documents,id',
            'actualVersionId' => 'integer|exists:document_versions,id'
        ];
    }
}
