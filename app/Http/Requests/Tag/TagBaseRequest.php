<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\ApiRequest;
use App\Tag;

abstract class TagBaseRequest extends ApiRequest
{
    public function getEntity(): Tag
    {
        return $this->transform(Tag::class);
    }
}