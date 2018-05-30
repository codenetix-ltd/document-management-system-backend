<?php

namespace Tests\Stubs;

use App\Entities\Type;

/**
 * Class TypeStub
 * @property Type $model
 */
class TypeStub extends AbstractStub
{
    /**
     * @var boolean
     */
    protected $replaceTimeStamps = true;

    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return Type::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'name' => $this->model->name,
            'machineName' => $this->model->machineName,
        ];
    }
}
