<?php

namespace App\Http\Requests\Attribute;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\AttributeService;
use Illuminate\Database\Eloquent\Model;

class AttributeShowRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('template_view');
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
