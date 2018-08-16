<?php

namespace App\Http\Requests\Attribute;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\AttributeService;
use App\Services\DocumentService;
use Illuminate\Database\Eloquent\Model;

class AttributeDestroyRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('template_delete');
    }

    /**
     * @param AttributeService $attributeService
     * @return Model
     */
    public function getTargetModel(AttributeService $attributeService): Model
    {
        return $attributeService->find($this->route()->parameter('attributeId'));
    }
}