<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ABaseFormRequest extends FormRequest
{
    /**
     * @return array
     */
    abstract public function rules(): array;
}
