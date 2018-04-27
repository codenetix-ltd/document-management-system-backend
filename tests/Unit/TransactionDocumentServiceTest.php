<?php

namespace Tests\Unit;

use App\Contracts\Repositories\IDocumentRepository;
use App\Contracts\Services\ITransaction;
use App\Document;
use App\DocumentVersion;
use App\Services\Document\DocumentVersionService;
use App\Services\Document\TransactionDocumentService;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class TransactionDocumentServiceTest extends TestCase
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

    private function createEmptyTransactionStub()
    {
        return $this->createMock(ITransaction::class);
    }

    public function testCreateSuccess()
    {
        $newId = 1;
        $documentRepositoryStub = $this->createMock(IDocumentRepository::class);
        $documentRepositoryStub->method('save')->willReturn($newId);
        $transactionMock = $this->createEmptyTransactionStub();
        $transactionMock->expects($this->once())->method('beginTransaction');
        $transactionMock->expects($this->once())->method('commit');
        $transactionMock->expects($this->never())->method('rollback');
        $documentService = new TransactionDocumentService($documentRepositoryStub, $this->createEmptyDocumentVersionServiceStub(),$transactionMock);
        $document = $this->createDocument();

        $resultDocument = $documentService->create($document);

        $this->assertEquals($newId, $resultDocument->getId());
    }

    public function testCreateRollbackException()
    {
        $ex = new \Exception();
        $this->expectExceptionObject($ex);

        $documentRepositoryStub = $this->createMock(IDocumentRepository::class);
        $documentRepositoryStub->method('save')->willThrowException($ex);
        $transactionMock = $this->createEmptyTransactionStub();
        $transactionMock->expects($this->once())->method('beginTransaction');
        $transactionMock->expects($this->never())->method('commit');
        $transactionMock->expects($this->once())->method('rollback');
        $documentService = new TransactionDocumentService($documentRepositoryStub, $this->createEmptyDocumentVersionServiceStub(),$transactionMock);
        $document = $this->createDocument();

        $documentService->create($document);
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
        $documentRepositoryStub = $this->createMock(IDocumentRepository::class);
        $documentRepositoryStub->method('findOrFail')->willReturn($oldDocument);
        $documentRepositoryStub->method('getActualVersionRelation')->willReturn($oldDocumentVersion);
        $transactionMock = $this->createEmptyTransactionStub();
        $transactionMock->expects($this->once())->method('beginTransaction');
        $transactionMock->expects($this->once())->method('commit');
        $transactionMock->expects($this->never())->method('rollback');
        $documentService = new TransactionDocumentService($documentRepositoryStub, $this->createEmptyDocumentVersionServiceStub(), $transactionMock);

        $result = $documentService->update(1, $newDocument, ['ownerId']);

        $this->assertEquals(2, $result->getOwnerId());
        $this->assertEquals('2', $newVersion->getVersionName());
    }

    public function testUpdateRollbackException()
    {
        //TODO only for unit tests
        require_once __DIR__.'/../../app/Helpers/SystemFunctions.php';

        $ex = new \Exception();

        $oldDocument = $this->createDocument();
        $oldDocumentVersion = $this->createDocumentVersion();

        $newDocument = new Document();
        $newDocument->setOwnerId(2);

        $newVersion = $this->createDocumentVersion();
        $newVersion->setComment('NEW COMMENT');

        $newDocument->setActualVersion($newVersion);
        $documentRepositoryStub = $this->createMock(IDocumentRepository::class);
        $documentRepositoryStub->method('findOrFail')->willReturn($oldDocument);
        $documentRepositoryStub->method('save')->willThrowException($ex);

        $this->expectExceptionObject($ex);
        $documentRepositoryStub->method('getActualVersionRelation')->willReturn($oldDocumentVersion);
        $transactionMock = $this->createEmptyTransactionStub();
        $transactionMock->expects($this->once())->method('beginTransaction');
        $transactionMock->expects($this->never())->method('commit');
        $transactionMock->expects($this->once())->method('rollback');
        $documentService = new TransactionDocumentService($documentRepositoryStub, $this->createEmptyDocumentVersionServiceStub(), $transactionMock);

        $documentService->update(1, $newDocument, ['ownerId']);

    }
}
