<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ApiRequest;
use App\Template;

abstract class TemplateBaseRequest extends ApiRequest
{
    protected $modelConfigName = 'TemplateRequest';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getEntity(): Template
    {
        return $this->transform(Template::class);
    }
}