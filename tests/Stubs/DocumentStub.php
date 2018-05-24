<?php

namespace Tests\Stubs;


use App\Entities\Document;
use App\Entities\DocumentVersion;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentStub
 * @package Tests\Stubs
 *
 * @property Document $model
 */
class DocumentStub extends AbstractStub
{
    /**
     * @var DocumentVersionStub
     */
    protected $actualDocumentVersionStub;

    protected $replaceTimeStamps = true;

    /**
     * @var DocumentVersion
     */
    protected $actualVersion;

    protected function buildModel($valuesToOverride = [], $persisted = false, $states = [])
    {
        parent::buildModel($valuesToOverride, $persisted, $states);

        $this->actualDocumentVersionStub = new DocumentVersionStub([
            'document_id' => $this->model->id,
            'is_actual' => 1,
        ], $persisted);
    }

    /**
     * @param Document $model
     */
    protected function initiateByModel($model)
    {
        parent::initiateByModel($model);

        $this->actualDocumentVersionStub = new DocumentVersionStub([], true, [], $model->documentActualVersion);
    }

    /**
     * @return string
     */
    protected function getModelName()
    {
        return Document::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [
            'ownerId' => $this->model->ownerId,
            'actualVersion' => $this->actualDocumentVersionStub->buildRequest()
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'ownerId' => $this->model->ownerId,
            'substituteDocumentId' => null,
            'actualVersion' => $this->actualDocumentVersionStub->buildResponse(),
            'version' => (string)$this->actualDocumentVersionStub->getModel()->versionName,
            'owner' => (new UserStub([], true, [], $this->model->owner))->buildResponse(),
        ];
    }
}