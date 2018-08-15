<?php

namespace App\Http\Requests\Label;

use App\Http\Requests\ABaseAPIRequest;

class LabelStoreRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('label_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required|max:255|unique:labels'
        ];
    }
}
