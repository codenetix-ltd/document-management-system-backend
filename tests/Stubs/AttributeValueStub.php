<?php

namespace Tests\Stubs;

use App\Entities\AttributeValue;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 *
 * @property AttributeValue $model
 */
class AttributeValueStub extends AbstractStub
{

    /**
     * @return string
     */
    protected function getModelName()
    {
        return AttributeValue::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
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
    protected function doBuildResponse()
    {
        return [
            'id' => $this->model->attribute->id,
            'value' => $this->model->value,
            'type' => $this->model->attribute->type->machineName
        ];
    }
}
