<?php

namespace App\Http\Requests\Attribute;

class AttributeStoreRequest extends AttributeBaseRequest
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
            'name' => 'required|max:255',
            'typeId' => 'required|integer|exists:types,id',
            'data' => 'sometimes|required|array'
        ];
    }

    public function getModelStructure(): array
    {
        return config('models.attribute_store_request');
    }
}
