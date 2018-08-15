<?php

namespace App\Http\Requests\DocumentVersion;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentVersionService;
use Illuminate\Support\Facades\Auth;

class DocumentVersionUpdateRequest extends ABaseAPIRequest
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
