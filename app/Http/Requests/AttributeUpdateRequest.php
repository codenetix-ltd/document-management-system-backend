<?php

namespace App\Http\Requests;

class AttributeUpdateRequest extends ABaseFormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'data' => 'sometimes|nullable|array'
        ];
    }
}
