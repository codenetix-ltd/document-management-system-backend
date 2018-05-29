<?php

namespace Tests\Stubs\Requests;

use App\Entities\Attribute;
use Tests\Stubs\AbstractStub;
use Tests\Stubs\StubInterface;

/**
 * Class DocumentAttributeValueStub
 * @package Tests\Stubs\Requests
 *
 * @property Attribute $model
 */
class DocumentAttributeValueStub extends AbstractStub
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
            'id' => $this->model->id,
            'value' => 'testValue',
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [];
    }
}
