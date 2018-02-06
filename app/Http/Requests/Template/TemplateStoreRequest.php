<?php

namespace App\Http\Requests\Template;

class TemplateStoreRequest extends TemplateBaseRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:templates|max:255'
        ];
    }

    public function getModelStructure(): array
    {
        return config('models.template_store_request');
    }
}
