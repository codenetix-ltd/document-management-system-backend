<?php

namespace Tests\Stubs;

use App\Entities\AttributeValue;

/**
 * Class AttributeValueStub
 * @property AttributeValue $model
 */
class AttributeValueStub extends AbstractStub
{
    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return AttributeValue::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [
            'id' => $this->model->attribute->id,
            'value' => $this->model->value,
            'type' => $this->model->attribute->type->machineName
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'id' => $this->model->attribute->id,
            'value' => $this->model->value,
            'type' => $this->model->attribute->type->machineName
        ];
    }
}
