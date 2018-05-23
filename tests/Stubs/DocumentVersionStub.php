<?php

namespace Tests\Stubs;

use App\Entities\DocumentVersion;
use App\Entities\Label;
use App\File;
use Illuminate\Support\Collection;
use Tests\Stubs\Requests\DocumentAttributeValueStub;

/**
 * Class DocumentVersionStub
 * @package Tests\Stubs
 *
 * @property DocumentVersion $model
 */
class DocumentVersionStub extends AbstractStub
{
    /**
     * @var Collection
     */
    protected $labels;

    /**
     * @var Collection
     */
    protected $files;

    /**
     * @var DocumentAttributeValueStub
     */
    protected $documentAttributeValueStub;

    public function __construct(array $valuesToOverride = [], bool $persisted = false)
    {
        parent::__construct($valuesToOverride, $persisted);

        $this->labels = factory(Label::class, 3)->create();
        $this->files = factory(File::class, 3)->create();

        $this->documentAttributeValueStub = new DocumentAttributeValueStub();

        if($persisted) {
            $this->model->labels()->sync($this->labels->pluck('id')->toArray());
            $this->model->files()->sync($this->files->pluck('id')->toArray());
        }

    }

    /**
     * @return string
     */
    protected function getModelName()
    {
        return DocumentVersion::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [
            'name' => $this->model->name,
            'templateId' => $this->model->templateId,
            'comment' => $this->model->comment,
            'labelIds' => $this->labels->pluck('id')->toArray(),
            'fileIds' => $this->files->pluck('id')->toArray(),
            'attributeValues' => [
                $this->documentAttributeValueStub->buildRequest()
            ]
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'name' => $this->model->name,
            'templateId' => $this->model->templateId,
            'comment' => $this->model->comment,
            'labelIds' => $this->labels->pluck('id')->toArray(),
            'fileIds' => $this->files->pluck('id')->toArray(),
            'attributeValues' => [
                $this->documentAttributeValueStub->buildResponse()
            ]
        ];
    }
}