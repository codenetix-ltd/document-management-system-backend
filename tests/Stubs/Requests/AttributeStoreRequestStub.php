<?php

namespace Tests\Stubs\Requests;

use App\Entities\Attribute;
use App\Entities\Template;

class AttributeStoreRequestStub
{
    public function buildAttributeWithTypeString(): array
    {
        $attribute = factory(Attribute::class)->create();
        $template = factory(Template::class)->create();

        return [
            'attribute' => [
                'name' => $attribute->name,
                'typeId' => $attribute->type_id
            ],
            'templateId' => $template->id
        ];
    }
}