<?php

namespace Tests\Stubs;

use App\Entities\Attribute;
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
    protected $replaceTimeStamps = true;
    /**
     * @var Collection
     */
    protected $labels;

    /**
     * @var Collection
     */
    protected $files;

    /**
     * @var Collection
     */
    protected $attributeValuesStubs;

    /**
     * @var DocumentAttributeValueStub
     */
    protected $documentAttributeValueStub;

    protected function buildModel($valuesToOverride = [], $persisted = false, $states = [])
    {
        parent::buildModel($valuesToOverride, $persisted, $states);

        $this->labels = factory(Label::class, 3)->create();
        $this->files = factory(File::class, 3)->create();

        $this->attributeValuesStubs = new Collection();
        for($i=0;$i<3;++$i) {
            $this->attributeValuesStubs->push(new AttributeValueStub(['document_version_id' => $this->model->id], $persisted));
        }

        if ($persisted) {
            $this->model->labels()->sync($this->labels->pluck('id')->toArray());
            $this->model->files()->sync($this->files->pluck('id')->toArray());
        }
    }

    /**
     * @param DocumentVersion $model
     */
    protected function initiateByModel($model)
    {
        parent::initiateByModel($model);

        $this->labels = $model->labels;
        $this->files = $model->files;

        $this->attributeValuesStubs = $model->attributeValues->map(function($item){
            return new AttributeValueStub([], true, [], $item);
        });
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
            'attributeValues' => $this->attributeValuesStubs->map(function($item){
                /** @var AttributeValueStub $item */
                return $item->doBuildRequest();
            })->toArray(),
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
            'labels' => $this->labels->map(function ($item) {
                return (new LabelStub([], true, [], $item))->buildResponse();
            })->toArray(),
            'fileIds' => $this->files->pluck('id')->toArray(),
            'files' => $this->files->map(function ($item) {
                return (new FileStub([], true, [], $item))->buildResponse();
            })->toArray(),
            'attributeValues' => $this->attributeValuesStubs->map(function($item){
                /** @var AttributeValueStub $item */
                return $item->doBuildResponse();
            })->toArray(),
            'template' => (new TemplateStub([], true, [], $this->model->template))->buildResponse(),
        ];
    }
}