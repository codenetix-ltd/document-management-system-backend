<?php

namespace Tests\Unit;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;
use App\DocumentVersion;
use App\Services\Components\IEventDispatcher;
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

    private function createDocumentService(
        $repository = null,
        $documentVersionService = null,
        $eventDispatcher = null
    )
    {
        return new DocumentService(
            $repository ?? $this->createMock(IDocumentRepository::class),
            $documentVersionService ?? $this->createEmptyDocumentVersionServiceStub(),
            $eventDispatcher ?? $this->createMock(IEventDispatcher::class)
        );
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
        $documentService = $this->createDocumentService($documentRepositoryMock);
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
        $documentService = $this->createDocumentService($documentRepositoryMock, $documentVersionServiceMock);
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
        $documentService = $this->createDocumentService($documentRepositoryMock);

        $resultDocument = $documentService->get(1);

        $this->assertEquals($document, $resultDocument);
    }

    public function testGetNotFound()
    {
        $exception = (new ModelNotFoundException)->setModel(Document::class);
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->method('findOrFail')->willThrowException($exception);
        $documentService = $this->createDocumentService($documentRepositoryMock);

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
        $documentService = $this->createDocumentService($documentRepositoryMock);

        $result = $documentService->update(1, $newDocument, ['ownerId']);

        $this->assertEquals(2, $result->getOwnerId());
        $this->assertEquals('2', $newVersion->getVersionName());
    }

    public function testUpdateNoNewVersionSuccess()
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
        $documentVersionServiceMock = $this->createEmptyDocumentVersionServiceStub();
        $documentVersionServiceMock->expects($this->once())->method('delete');
        $documentVersionServiceMock->expects($this->once())->method('create');
        $documentService = $this->createDocumentService($documentRepositoryMock, $documentVersionServiceMock);

        $result = $documentService->update(1, $newDocument, ['ownerId'], false);

        $this->assertEquals(2, $result->getOwnerId());
        $this->assertEquals('1', $newVersion->getVersionName());
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

        $documentService = $this->createDocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $result = $documentService->update(1, $newDocument, []);

        $this->assertEquals(1, $result->getOwnerId());
        $this->assertEquals('2', $newVersion->getVersionName());

    }

    public function testDeleteSuccess()
    {
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->expects($this->once())->method('delete')->willReturn(true);
        $documentRepositoryMock->expects($this->once())->method('find')->willReturn(new Document());
        $documentService = $this->createDocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $result = $documentService->delete(1);

        $this->assertTrue($result);
    }

    public function testDeleteNotExistsSuccess()
    {
        $documentRepositoryMock = $this->createMock(IDocumentRepository::class);
        $documentRepositoryMock->expects($this->never())->method('delete');
        $documentService = $this->createDocumentService($documentRepositoryMock, $this->createEmptyDocumentVersionServiceStub());

        $result = $documentService->delete(1);

        $this->assertFalse($result);
    }

    public function testChangeActualVersionSuccess()
    {
        $oldDV = $this->createDocumentVersion()->setActual(true);
        $newDV = $this->createDocumentVersion()->setActual(false);
        $document = $this->createDocument();

        $dvsMock = $this->createEmptyDocumentVersionServiceStub();
        $dvsMock->expects($this->exactly(2))->method('update');
        $dvsMock->method('get')->willReturn($newDV);

        $documentRepositoryStub = $this->createMock(IDocumentRepository::class);
        $documentRepositoryStub->method('getActualVersionRelation')->willReturn($oldDV);
        $documentRepositoryStub->method('findOrFail')->willReturn($document);

        $documentService = $this->createDocumentService($documentRepositoryStub, $dvsMock);
        $documentService->setActualVersion(1, 1);

        $this->assertTrue($newDV->isActual());
        $this->assertFalse($oldDV->isActual());
    }

    public function testChangeActualVersionFail()
    {
        $oldDV = $this->createDocumentVersion()->setActual(true);
        $newDV = $this->createDocumentVersion()->setActual(false)->setDocumentId(0);
        $document = $this->createDocument();

        $dvsMock = $this->createEmptyDocumentVersionServiceStub();
        $dvsMock->expects($this->never())->method('update');
        $dvsMock->method('get')->willReturn($newDV);

        $documentRepositoryStub = $this->createMock(IDocumentRepository::class);
        $documentRepositoryStub->method('getActualVersionRelation')->willReturn($oldDV);
        $documentRepositoryStub->method('findOrFail')->willReturn($document);

        $documentService = $this->createDocumentService($documentRepositoryStub, $dvsMock);
        $this->expectException(ModelNotFoundException::class);

        $documentService->setActualVersion(1, 1);
    }
}
