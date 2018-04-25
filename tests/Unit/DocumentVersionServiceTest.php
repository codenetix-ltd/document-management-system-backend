<?php

namespace Tests\Unit;

use App\Contracts\Repositories\IDocumentRepository;
use App\Contracts\Repositories\IDocumentVersionRepository;
use App\Document;
use App\DocumentVersion;
use App\Services\Document\DocumentVersionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentVersionServiceTest extends TestCase
{
    private function createDocumentVersion()
    {
        $documentVersion = new DocumentVersion();
        $documentVersion
            ->setVersionName('123')
            ->setActual(true)
            ->setComment('comment')
            ->setDocumentId(1)
            ->setTemplateId(1)
            ->setName('name');

        return $documentVersion;
    }

    public function testCreateSuccess()
    {
        $newId = 1;
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('save')->willReturn($newId);
        $documentVersionService = new DocumentVersionService($documentVersionRepositoryMock);
        $documentVersion = $this->createDocumentVersion();

        $resultDocumentVersion = $documentVersionService->create($documentVersion);

        $this->assertEquals($newId, $resultDocumentVersion->getId());
    }

    public function testGetSuccess()
    {
        $documentVersion = $this->createDocumentVersion();

        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('findOrFail')->willReturn($documentVersion);
        $documentVersionService = new DocumentVersionService($documentVersionRepositoryMock);

        $result = $documentVersionService->get(1);

        $this->assertEquals($documentVersion, $result);
    }

    public function testGetNotFound()
    {
        $exception = (new ModelNotFoundException)->setModel(DocumentVersion::class);
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('findOrFail')->willThrowException($exception);
        $documentVersionService = new DocumentVersionService($documentVersionRepositoryMock);

        $this->expectExceptionObject($exception);

        $documentVersionService->get(1);
    }


    public function testDeleteSuccess()
    {
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->expects($this->once())->method('delete');
        $documentVersionService = new DocumentVersionService($documentVersionRepositoryMock);

        $documentVersionService->delete(1);
    }
}
