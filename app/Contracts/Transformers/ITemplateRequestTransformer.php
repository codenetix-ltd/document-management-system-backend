<?php

namespace App\Contracts\Transformers;

use App\Contracts\Models\ITemplate;

//TODO - убрать, переименовать
interface ITemplateRequestTransformer extends IUpdateRequestTransformer
{
    public function getEntity(): ITemplate;
}