<?php

namespace App\Http\Requests\Document;

use App\Context\DocumentAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;

class DocumentBulkDestroyRequest extends ABaseAPIRequest
{

    /**
     * @return array
     */
    public function getFilteredIds()
    {
        $result = [];

        $ids = explode(',', $this->get('ids', ''));

        $service = $this->container->make(DocumentService::class);

        foreach ($ids as $id) {
            $document = $service->find($id);
            if ((new DocumentAuthorizer(new DocumentAuthorizeContext(Auth::user(), $document)))
                ->check('document_delete')) {
                $result[] = $id;
            }
        }

        return $result;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
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
            $bulkRules['*.' . $k] = $v;
        }

        return $bulkRules;
    }
}
