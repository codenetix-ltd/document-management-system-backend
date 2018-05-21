<?php

namespace Tests\Stubs;

use App\Entities\Attribute;
use App\Entities\Template;
use App\Repositories\TypeRepository;

class AttributeWithTypeTableStub
{
    private $attribute;
    private $template;

    public function __construct()
    {
        $this->attribute = factory(Attribute::class)->states('table')->make();
        $this->template = factory(Template::class)->create();
    }

    public function buildRequest(): array
    {
        return [
            'name' => $this->attribute->name,
            'typeId' => $this->attribute->typeId,
            'data' => $this->buildAttributeData()
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
            'data' => $this->buildAttributeData(),
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

    private function buildAttributeData(): array
    {
        $typeRepository = app()->make(TypeRepository::class);
        $typeString = $typeRepository->getTypeByMachineName('string');

        return [
            'rows' => [
                [
                    'name' => 'row1',
                    'columns' => [
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ]
                    ]
                ],
                [
                    'name' => 'row2',
                    'columns' => [
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ]
                    ]
                ]
            ],
            'headers' => [
                [
                    'name' => 'header1',
                ],
                [
                    'name' => 'header2',
                ],
            ]
        ];
    }
}