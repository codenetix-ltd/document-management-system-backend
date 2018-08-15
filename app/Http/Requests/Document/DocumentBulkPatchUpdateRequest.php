<?php

namespace App\Http\Requests\Document;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;

class DocumentBulkPatchUpdateRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        $ids = explode(',', $this->get('ids', ''));

        if (count($ids) !== $this->json()->count()) {
            return false;
        }

        $service = $this->container->make(DocumentService::class);

        foreach ($ids as $key => $currentId) {
            $document = $service->find($currentId);
            if (!(new DocumentAuthorizer(new DocumentAuthorizeContext(Auth::user(), $document)))
                ->check('document_update')) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $bulkRules = [
            '' => 'array'
        ];

        foreach ($rules as $k => $v) {
            $bulkRules['*.'.$k] = $v;
        }

        return $bulkRules;
    }
}
