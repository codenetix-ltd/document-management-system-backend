<?php

namespace App\Http\Requests\Document;

use App\Http\Requests\ApiRequest;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentSetActualVersionRequest extends ApiRequest
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

    public function getVersionId(): int
    {
        return $this->get('versionId');
    }

    public function rules()
    {
        //TODO use $modelConfigName
        return [
            'versionId' => 'integer|required'
        ];
    }

}
