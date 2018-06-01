<?php

namespace Tests\Stubs;

use App\Entities\Attribute;

/**
 * Class AttributeWithTypeStringStub
 * @property Attribute $model
 */
class AttributeWithTypeStringStub extends AbstractStub
{
    /** @var bool $replaceTimeStamps */
    protected $replaceTimeStamps = true;

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
            'typeId' => $this->model->typeId
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
            'data' => null,
            'isLocked' => $this->model->isLocked,
            'order' => $this->model->order,
            'templateId' => $this->model->templateId,
        ];
    }
}
