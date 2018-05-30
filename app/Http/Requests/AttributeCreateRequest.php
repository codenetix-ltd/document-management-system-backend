<?php

namespace App\Http\Requests;

class AttributeCreateRequest extends ABaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'typeId' => "required|integer|exists:types,id",
            'data' => 'sometimes|required|array'//TODO - Add validator
        ];
    }
}
