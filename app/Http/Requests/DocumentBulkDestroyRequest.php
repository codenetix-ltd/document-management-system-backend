<?php

namespace App\Http\Requests;

use App\Context\DocumentAuthorizeContext;
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
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
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
