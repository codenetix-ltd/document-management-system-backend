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

    public function __construct(array $valuesToOverride = [], bool $persisted = false)
    {
        parent::__construct($valuesToOverride, $persisted);

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
                /** @var Label $item */
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'createdAt' => $item->createdAt->timestamp,
                    'updatedAt' => $item->updatedAt->timestamp,
                ];
            })->toArray(),
            'fileIds' => $this->files->pluck('id')->toArray(),
            'files' => $this->files->map(function ($item) {
                /** @var File $item */
                return [
                    'name' => $item->getOriginalName(),
                    'url' => $item->getPath()
                ];
            })->toArray(),
            'attributeValues' => $this->attributeValuesStubs->map(function($item){
                /** @var AttributeValueStub $item */
                return $item->doBuildResponse();
            })->toArray(),
            'template' => [
                'name' => $this->model->template->name,
                'id' => $this->model->template->id,
                'createdAt' => $this->model->template->createdAt->timestamp,
                'updatedAt' => $this->model->template->updatedAt->timestamp,
                'attributes' => $this->model->template->attributes->map(function($item){
                    /** @var Attribute $item */
                    return [
                        'id' => $item->id,
                        'type' => [
                            'id' => $item->type->id,
                            'name' => $item->type->name,
                            'machineName' => $item->type->machineName,
                            'createdAt' => $item->type->createdAt->timestamp,
                            'updatedAt' => $item->type->updatedAt->timestamp
                        ],
                        'name' => $item->name,
                        'data' => null,
                        'isLocked' => $item->isLocked,
                        'order' => $item->order,
                        'templateId' => $item->templateId,
                        'createdAt' => $item->createdAt->timestamp,
                        'updatedAt' => $item->updatedAt->timestamp
                    ];
                })->toArray()
            ],
        ];
    }
}