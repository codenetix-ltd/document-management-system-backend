<?php

namespace Tests\Stubs;

use App\Entities\Type;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 *
 * @property Type $model
 */
class TypeStub extends AbstractStub
{
    protected $replaceTimeStamps = true;
    /**
     * @return string
     */
    protected function getModelName()
    {
        return Type::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'name' => $this->model->name,
            'machineName' => $this->model->machineName,
        ];
    }
}
