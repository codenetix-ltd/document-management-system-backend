<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\ApiRequest;
use App\Tag;

abstract class TagBaseRequest extends ApiRequest
{
    protected $modelConfigName = 'LabelRequest';

    public function getEntity(): Tag
    {
        return $this->transform(Tag::class);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}