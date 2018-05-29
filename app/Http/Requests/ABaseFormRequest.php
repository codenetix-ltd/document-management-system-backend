<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ABaseFormRequest extends FormRequest
{
    abstract public function rules(): array;

    public function getInputData()
    {
        return $this->only(array_keys($this->rules()));
    }
}
