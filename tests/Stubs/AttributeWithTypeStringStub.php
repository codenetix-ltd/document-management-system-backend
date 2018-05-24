<?php

namespace Tests\Stubs;

use App\Entities\Attribute;

/**
 * Class AttributeWithTypeStringStub
 * @package Tests\Stubs
 *
 * @property Attribute $model
 */
class AttributeWithTypeStringStub extends AbstractStub
{
    protected $replaceTimeStamps = true;
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
            'typeId' => $this->model->typeId
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
            'data' => null,
            'isLocked' => $this->model->isLocked,
            'order' => $this->model->order,
            'templateId' => $this->model->templateId,
        ];
    }
}