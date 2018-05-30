<?php

namespace Tests\Stubs;

use App\Entities\File;

/**
 * Class FileStub
 * @property File $model
 */
class FileStub extends AbstractStub
{
    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return File::class;
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
            'name' => $this->model->originalName,
            'url' => $this->model->path
        ];
    }
}
