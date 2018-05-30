<?php

namespace Tests\Stubs\Requests;

use App\Entities\Attribute;
use Tests\Stubs\AbstractStub;

/**
 * Class DocumentAttributeValueStub
 * @property Attribute $model
 */
class DocumentAttributeValueStub extends AbstractStub
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
            'id' => $this->model->id,
            'value' => 'testValue',
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [];
    }
}
