<?php

namespace Tests\Stubs;


use App\Entities\Document;
use App\Entities\DocumentVersion;

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

    public function __construct(array $valuesToOverride = [], bool $persisted = false)
    {
        parent::__construct($valuesToOverride, $persisted);

        $this->actualDocumentVersionStub = new DocumentVersionStub([
            'document_id' => $this->model->id,
            'is_actual' => 1,
        ], $persisted);
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
            'owner' => [
                'id' => $this->model->owner->id,
                'fullName' => $this->model->owner->fullName,
                'email' => $this->model->owner->email,
                'templateIds' => $this->model->owner->templates->pluck('id')->toArray(),
                'avatar' => [
                    'name'=>$this->model->owner->avatar->getOriginalName(),
                    'url' => $this->model->owner->avatar->getPath()
                ],
                'avatarId' => $this->model->owner->avatar->getId(),
            ]
        ];
    }
}