<?php

namespace Tests\Stubs;


use App\Entities\Document;

class DocumentStub implements StubInterface
{

    protected $document;
    protected $actualDocumentVersionStub;

    public function buildModel($valuesToOverride = [], $persisted = false)
    {
        $this->document = factory(Document::class)->{$persisted ? 'create' : 'make'}($valuesToOverride);

        $versionStub = new DocumentVersionStub();
        $versionStub->buildModel([
            'document_id' => $this->document->id,
            'is_actual' => 1
        ], $persisted);

        $this->document->atttach($versionStub->getModel());

        $this->actualDocumentVersionStub = $versionStub;

        return $this;
    }

    public function buildRequest($valuesToOverride = []): array
    {
        return array_merge_recursive([
            'ownerId' => $this->document->ownerId,
            'actualVersion' => $this->actualDocumentVersionStub->buildRequest()
        ], $valuesToOverride);
    }

    public function buildResponse($valuesToOverride = []): array
    {
        return array_merge_recursive([

            'ownerId' => $this->document->ownerId,
            'substituteDocumentId' => null,
            'actualVersion' => $this->actualDocumentVersionStub->buildReponse()
        ], $valuesToOverride);
    }

    public function getModel()
    {
        return $this->document;
    }
}