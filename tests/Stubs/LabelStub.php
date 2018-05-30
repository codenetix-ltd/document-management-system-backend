<?php

namespace Tests\Stubs;

use App\Entities\Label;

/**
 * Class LabelStub
 * @property Label $model
 */
class LabelStub extends AbstractStub
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
        return Label::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [
            'name' => $this->model->name,
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'name' => $this->model->name,
        ];
    }
}
