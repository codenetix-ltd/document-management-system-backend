<?php

namespace App\Http\Requests\Tag;

use App\Contracts\Models\ITag;
use App\Contracts\Transformers\ITagRequestTransformer;
use Illuminate\Foundation\Http\FormRequest;

class TagBaseRequest extends FormRequest implements ITagRequestTransformer
{
    private $updatedFields = [];

    //TODO - refactoring убрать отсюда в отдельный сервис
    public function getEntity(): ITag
    {
        $tag = $this->container->make(ITag::class);

        foreach ($this->all() as $fieldKey => $fieldValue) {
            $methodName = dms_build_setter($fieldKey);
            if (method_exists($tag, $methodName)) {
                $tag->{$methodName}($fieldValue);
                array_push($this->updatedFields, $fieldKey);
            }
        }

        return $tag;
    }

    public function getUpdatedFields(): array
    {
        return $this->updatedFields;
    }
}