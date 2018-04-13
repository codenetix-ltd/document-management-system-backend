<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ApiRequest;
use App\Template;

abstract class TemplateBaseRequest extends ApiRequest
{
    public function getEntity(): Template
    {
        return $this->transform(Template::class);
    }
}