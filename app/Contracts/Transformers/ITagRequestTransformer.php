<?php

namespace App\Contracts\Transformers;

use App\Contracts\Models\ITag;

//TODO - убрать, переименовать
interface ITagRequestTransformer extends IUpdateRequestTransformer
{
    public function getEntity(): ITag;
}