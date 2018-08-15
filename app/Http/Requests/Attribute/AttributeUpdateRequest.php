<?php

namespace App\Http\Requests\Attribute;

use App\Http\Requests\ABaseAPIRequest;

class AttributeUpdateRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('template_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'attributeData' => 'sometimes|nullable|array'
        ];
    }
}
