<?php

namespace Tests\Stubs;

use App\Entities\DocumentVersion;
use App\Entities\Label;
use App\File;
use Tests\Stubs\Requests\DocumentAttributeValueStub;

class DocumentVersionStub implements StubInterface
{
    protected $documentVersion;
    protected $labels;
    protected $files;
    protected $documentAttributeValueStub;


    public function buildRequest($valuesToOverride = []): array
    {
        return [
            'name' => $this->documentVersion->name,
            'templateId' => $this->documentVersion->template_id,
            'comment' => $this->documentVersion->comment,
            'labelIds' => $this->labels->pluck('id'),
            'fileIds' => $this->files->pluck('id'),
            'attributeValues' => [
                $this->documentAttributeValueStub->buildRequest()
            ]
        ];
    }

    public function buildResponse($valuesToOverride = []): array
    {
        return [
            'name' => $this->documentVersion->name,
            'templateId' => $this->documentVersion->template_id,
            'comment' => $this->documentVersion->comment,
            'labelIds' => $this->labels->pluck('id'),
            'fileIds' => $this->files->pluck('id'),
            'attributeValues' => [
                $this->documentAttributeValueStub->buildResponse()
            ]
        ];
    }

    public function buildModel($valuesToOverride = [], $persisted = false)
    {
        $this->documentVersion = factory(DocumentVersion::class)->{$persisted ? 'create' : 'make'}($valuesToOverride);
        $this->labels = factory(Label::class, 3)->create();
        $this->files = factory(File::class, 3)->create();
        $this->documentAttributeValueStub = new DocumentAttributeValueStub();
    }

    public function getModel()
    {
        return $this->documentVersion;
    }
}