<?php

namespace App\Http\Requests\Tag;

use App\Contracts\Models\ITag;
use App\Http\Requests\ApiRequest;

abstract class TagBaseRequest extends ApiRequest
{
    public function getEntity(): ITag
    {
        return $this->transform(ITag::class, $this->getModelStructure());
    }

    public abstract function getModelStructure(): array;
}