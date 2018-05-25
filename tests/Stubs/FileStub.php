<?php

namespace Tests\Stubs;

use App\Entities\File;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 *
 * @property File $model
 */
class FileStub extends AbstractStub
{

    /**
     * @return string
     */
    protected function getModelName()
    {
        return File::class;
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
            'name' => $this->model->originalName,
            'url' => $this->model->path
        ];
    }
}
