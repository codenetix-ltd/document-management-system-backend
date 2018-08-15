<?php

namespace Tests\Stubs;

use App\Entities\Attribute;
use App\Repositories\TypeRepository;

/**
 * Class AttributeWithTypeTableStub
 * @property Attribute $model
 */
class AttributeWithTypeTableStub extends AbstractStub
{
    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return Attribute::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [
            'name' => $this->model->name,
            'typeId' => $this->model->typeId,
            'attributeData' => $this->buildAttributeData(),
            'templateId' => $this->model->templateId
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'typeId' => $this->model->typeId,
            'name' => $this->model->name,
            'attributeData' => $this->buildAttributeData(),
            'isLocked' => false,
            'order' => 0,
            'templateId' => $this->model->templateId,
        ];
    }

    /**
     * @return array
     */
    public function buildAttributeData(): array
    {
        /** @var TypeRepository $typeRepository */
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
