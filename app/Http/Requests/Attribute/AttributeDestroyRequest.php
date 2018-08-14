<?php

namespace App\Http\Requests\Attribute;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\AttributeService;
use App\Services\DocumentService;

class AttributeDestroyRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('template_delete');
    }

    /**
     * @param AttributeService $attributeService
     * @return mixed
     */
    public function getTargetModel(AttributeService $attributeService)
    {
        return $attributeService->find($this->route()->parameter('attributeId'));
    }
}
