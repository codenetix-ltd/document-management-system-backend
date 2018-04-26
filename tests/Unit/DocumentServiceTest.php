<?php

namespace Tests\Unit;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;
use App\DocumentVersion;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentVersionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentServiceTest extends TestCase
{
    private function createDocument()
    {
        $document = new Document();
        $document->setOwnerId(1);
        return $document;
    }

    private function createDocumentVersion()
    {
        $documentVersion = new DocumentVersion();
        $documentVersion
            ->setVersionName('1')
            ->setActual(true)
            ->setComment('comment')
            ->setDocumentId(1)
            ->setTemplateId(1)
            ->setName('name');

        return $documentVersion;
    }

    private function createEmptyDocumentVersionServiceStub()
    {
        return $this->createMock(DocumentVersionService::class);
    }

    public function testCreateSuccess()
    {
        $newId = 1;
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->method('save')->willReturn($newId);
        $documentService = new DocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());
        $document = $this->createDocument();

        $resultDocument = $documentService->create($document);

        $this->assertEquals($newId, $resultDocument->getId());
    }

    public function testCreateWithVersionSuccess()
    {
        $newId = 1;
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentVersionServiceMock = $this->createEmptyDocumentVersionServiceStub();
        $documentVersionServiceMock->expects(self::once())->method('create');
        $documentRepositoryMock->method('save')->willReturn($newId);
        $documentService = new DocumentService($documentRepositoryMock, $documentVersionServiceMock);
        $document = $this->createDocument();
        $document->setActualVersion($this->createDocumentVersion());

        $resultDocument = $documentService->create($document);

        $this->assertEquals($newId, $resultDocument->getId());
    }

    public function testGetSuccess()
    {
        $document = $this->createDocument();

        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->method('findOrFail')->willReturn($document);
        $documentService = new DocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $resultDocument = $documentService->get(1);

        $this->assertEquals($document, $resultDocument);
    }

    public function testGetNotFound()
    {
        $exception = (new ModelNotFoundException)->setModel(Document::class);
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->method('findOrFail')->willThrowException($exception);
        $documentService = new DocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $this->expectExceptionObject($exception);

        $documentService->get(1);
    }

    public function testUpdateSuccess()
    {
        //TODO only for unit tests
        require_once __DIR__.'/../../app/Helpers/SystemFunctions.php';

        $oldDocument = $this->createDocument();
        $oldDocumentVersion = $this->createDocumentVersion();

        $newDocument = new Document();
        $newDocument->setOwnerId(2);

        $newVersion = $this->createDocumentVersion();
        $newVersion->setComment('NEW COMMENT');

        $newDocument->setActualVersion($newVersion);
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->method('findOrFail')->willReturn($oldDocument);
        $documentRepositoryMock->method('getActualVersionRelation')->willReturn($oldDocumentVersion);
        $documentService = new DocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $result = $documentService->update(1, $newDocument, ['ownerId']);

        $this->assertEquals(2, $result->getOwnerId());
        $this->assertEquals('2', $newVersion->getVersionName());
    }

    public function testUpdateWithoutUpdatedFieldNoUpdate()
    {
        //TODO only for unit tests
        require_once __DIR__.'/../../app/Helpers/SystemFunctions.php';

        $oldDocument = $this->createDocument();
        $oldDocumentVersion = $this->createDocumentVersion();

        $newDocument = new Document();
        $newDocument->setOwnerId(2);

        $newVersion = $this->createDocumentVersion();
        $newVersion->setComment('NEW COMMENT');

        $newDocument->setActualVersion($newVersion);

        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->method('findOrFail')->willReturn($oldDocument);
        $documentRepositoryMock->method('getActualVersionRelation')->willReturn($oldDocumentVersion);

        $documentService = new DocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $result = $documentService->update(1, $newDocument, []);

        $this->assertEquals(1, $result->getOwnerId());
        $this->assertEquals('2', $newVersion->getVersionName());

    }

    public function testDeleteSuccess()
    {
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->expects($this->once())->method('delete');
        $documentService = new DocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $documentService->delete(1);
    }
}
