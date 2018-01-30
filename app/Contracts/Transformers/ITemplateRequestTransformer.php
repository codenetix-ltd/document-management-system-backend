<?php

namespace App\Contracts\Transformers;

use App\Contracts\Models\ITemplate;

interface ITemplateRequestTransformer extends IUpdateRequestTransformer
{
    public function getEntity(): ITemplate;
}