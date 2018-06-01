<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ABaseFormRequest extends FormRequest
{
    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @return array
     */
    public function getInputData()
    {
        return $this->only(array_keys($this->rules()));
    }
}
