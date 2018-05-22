<?php

namespace Tests\Stubs;

use App\Entities\Attribute;
use App\Repositories\TypeRepository;

class AttributeWithTypeTableStub extends AbstractStub
{
    /**
     * @return string
     */
    protected function getModelName()
    {
        return Attribute::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [
            'name' => $this->model->name,
            'typeId' => $this->model->typeId,
            'data' => $this->buildAttributeData()
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'type' => [
                'id' => $this->model->typeId,
                'name' => $this->model->type->name,
                'machineName' => $this->model->type->machineName,
                'createdAt' => $this->model->type->createdAt->timestamp,
                'updatedAt' => $this->model->type->updatedAt->timestamp
            ],
            'name' => $this->model->name,
            'data' => $this->buildAttributeData(),
            'isLocked' => false,
            'order' => 0,
            'templateId' => $this->model->templateId,
        ];
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