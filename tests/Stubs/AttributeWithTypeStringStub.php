<?php

namespace Tests\Stubs;

use App\Entities\Attribute;
use App\Entities\Template;

class AttributeWithTypeStringStub
{
    private $attribute;
    private $template;

    public function __construct()
    {
        $this->attribute = factory(Attribute::class)->make();
        $this->template = factory(Template::class)->create();
    }

    public function buildRequest(): array
    {
        return [
            'name' => $this->attribute->name,
            'typeId' => $this->attribute->typeId
        ];
    }

    public function buildResponse(Attribute $attributeModel): array
    {
        return [
            'id' => $attributeModel->id,
            'type' => [
                'id' => $this->attribute->typeId,
                'name' => $attributeModel->type->name,
                'machineName' => $attributeModel->type->machineName,
                'createdAt' => $attributeModel->type->createdAt->timestamp,
                'updatedAt' => $attributeModel->type->updatedAt->timestamp
            ],
            'name' => $this->attribute->name,
            'data' => null,
            'isLocked' => false,
            'order' => 0,
            'templateId' => $this->template->id,
            'createdAt' => $attributeModel->createdAt->timestamp,
            'updatedAt' => $attributeModel->updatedAt->timestamp
        ];
    }

    public function getTemplateId(): int
    {
        return $this->template->id;
    }
}