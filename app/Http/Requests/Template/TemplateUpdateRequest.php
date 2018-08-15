<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ABaseAPIRequest;

class TemplateUpdateRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
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
            'name' => 'string|required|max:255|unique:templates,name,'.$this->route('template'),
            //@TODO why we just cannot use the order of attributes as it is? Where is attribute validation rules???
            'orderOfAttributes' => 'sometimes|array'
        ];
    }
}
