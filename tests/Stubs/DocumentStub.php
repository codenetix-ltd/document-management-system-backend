<?php

namespace Tests\Stubs;

use App\Entities\Document;
use App\Entities\DocumentVersion;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentStub
 * @property Document $model
 */
class DocumentStub extends AbstractStub
{
    /**
     * @var DocumentVersionStub
     */
    protected $actualDocumentVersionStub;

    /**
     * @var boolean
     */
    protected $replaceTimeStamps = true;

    /**
     * @var DocumentVersion
     */
    protected $actualVersion;

    /**
     * @param array   $valuesToOverride
     * @param boolean $persisted
     * @param array   $states
     * @return void
     */
    protected function buildModel(array $valuesToOverride = [], bool $persisted = false, array $states = []): void
    {
        parent::buildModel($valuesToOverride, $persisted, $states);

        $this->actualDocumentVersionStub = new DocumentVersionStub([
            'document_id' => $this->model->id,
            'is_actual' => 1,
        ], $persisted);
    }

    /**
     * @param Model $model
     * @return void
     */
    protected function initiateByModel(Model $model): void
    {
        parent::initiateByModel($model);

        $this->actualDocumentVersionStub = new DocumentVersionStub([], true, [], $model->documentActualVersion);
    }

    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return Document::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [
            'ownerId' => $this->model->ownerId,
            'actualVersion' => $this->actualDocumentVersionStub->buildRequest()
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'ownerId' => $this->model->ownerId,
            'substituteDocumentId' => null,
            'actualVersion' => $this->actualDocumentVersionStub->buildResponse(),
            'version' => (string)$this->actualDocumentVersionStub->getModel()->versionName,
            'owner' => (new UserStub([], true, [], $this->model->owner))->buildResponse(),
            'authPermissions' => ['document_view' , 'document_update',  'document_delete', 'document_archive', 'document_create']
        ];
    }
}
