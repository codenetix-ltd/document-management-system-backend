<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;

class DocumentBulkPatchUpdateRequest extends DocumentPatchUpdateRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $bulkRules = [
            '' => 'array'
        ];

        foreach ($rules as $k => $v) {
            $bulkRules['*.'.$k] = $v;
        }

        return $bulkRules;
    }

    /**
     * @throws ValidationException
     * @return void
     */
    public function failValidation()
    {
        $this->failedValidation($this->getValidatorInstance());
    }
}
