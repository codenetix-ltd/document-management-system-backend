<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ABaseAPIRequest;

class TemplateStoreRequest extends ABaseAPIRequest
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
    public function rules()
    {
        return [
            'name' => 'string|required|max:255|unique:templates'
        ];
    }
}
