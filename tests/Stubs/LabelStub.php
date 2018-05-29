<?php

namespace Tests\Stubs;

use App\Entities\Label;

/**
 * Class LabelStub
 * @package Tests\Stubs
 * @property Label $model
 */
class LabelStub extends AbstractStub
{
    protected $replaceTimeStamps = true;

    /**
     * @return string
     */
    protected function getModelName()
    {
        return Label::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [
            'name' => $this->model->name,
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'name' => $this->model->name,
        ];
    }
}
