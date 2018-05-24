<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentBulkPatchUpdateRequest extends DocumentPatchUpdateRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $bulkRules = [
            '' => 'array'
        ];

        foreach($rules as $k => $v) {
            $bulkRules['*.'.$k] = $v;
        }

        return $bulkRules;
    }

    /**
     * @throws ValidationException
     */
    public function failValidation()
    {
        $this->failedValidation($this->getValidatorInstance());
    }
}
