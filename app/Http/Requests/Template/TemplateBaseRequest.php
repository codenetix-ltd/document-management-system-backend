<?php

namespace App\Http\Requests\Template;

use App\Contracts\Models\ITemplate;
use App\Http\Requests\ApiRequest;

abstract class TemplateBaseRequest extends ApiRequest
{
    public function getEntity(): ITemplate
    {
        return $this->transform(ITemplate::class);
    }
}