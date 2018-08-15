<?php

namespace App\Http\Requests\Document;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DocumentDestroyRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('document_delete');
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
        return $documentService->find($this->route()->parameter('document'));
    }
}
