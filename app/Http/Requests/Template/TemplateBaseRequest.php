<?php

namespace App\Http\Requests\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Transformers\ITemplateRequestTransformer;
use Illuminate\Foundation\Http\FormRequest;

class TemplateBaseRequest extends FormRequest implements ITemplateRequestTransformer
{
    private $updatedFields = [];

    public function getEntity(): ITemplate
    {
        $template = $this->container->make(ITemplate::class);

        foreach ($this->all() as $fieldKey => $fieldValue) {
            $methodName = dms_build_setter($fieldKey);
            if (method_exists($template, $methodName)) {
                $template->{$methodName}($fieldValue);
                array_push($this->updatedFields, $fieldKey);
            }
        }

        return $template;
    }

    public function getUpdatedFields(): array
    {
        return $this->updatedFields;
    }
}