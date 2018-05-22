<?php

namespace Tests\Stubs;

use App\Entities\Template;

/**
 * Class LabelStub
 * @package Tests\Stubs
 * @property Template $model
 */
class TemplateStub extends AbstractStub
{
    /**
     * @return string
     */
    protected function getModelName()
    {
        return Template::class;
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