<?php

namespace App\Http\Requests\Attribute;

use App\Http\Requests\ABaseAPIRequest;

class AttributeStoreRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('template_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'typeId' => "required|integer|exists:types,id",
            'attributeData' => 'sometimes|nullable|array',
            'templateId' => 'required|integer'
        ];
    }
}
