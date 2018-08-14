<?php

namespace App\Http\Requests\DocumentVersion;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use App\Services\DocumentVersionService;
use Illuminate\Support\Facades\Auth;

class DocumentVersionShowRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('document_view');
    }

    /**
     * @return AAuthorizer
     */
    protected function getAuthorizer()
    {
        return new DocumentAuthorizer(new DocumentAuthorizeContext(Auth::user(), $this->model()->document));
    }

    /**
     * @param DocumentVersionService $documentVersionService
     * @return mixed
     */
    public function getTargetModel(DocumentVersionService $documentVersionService)
    {
        return $documentVersionService->find($this->route()->parameter('documentVersionId'));
    }
}
