<?php

namespace Tests\Unit;

use App\AttributeValue;
use App\Contracts\Repositories\IAttributeValueRepository;
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

    private function createAttributeValueRepositoryMock()
    {
        return $this->createMock(IAttributeValueRepository::class);
    }

    public function testCreateSuccess()
    {
        $newId = 1;
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('save')->willReturn($newId);
        $documentVersionRepositoryMock->expects($this->once())->method('detachTags');
        $documentVersionRepositoryMock->expects($this->never())->method('syncTags');
        $documentVersionService = new DocumentVersionService(
            $documentVersionRepositoryMock,
            $this->createAttributeValueRepositoryMock()
        );
        $documentVersion = $this->createDocumentVersion();

        $resultDocumentVersion = $documentVersionService->create($documentVersion);

        $this->assertEquals($newId, $resultDocumentVersion->getId());
    }

    public function testCreateWithAttributesSuccess()
    {
        $newId = 1;
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('save')->willReturn($newId);
        $documentVersionRepositoryMock->expects($this->once())->method('detachTags');
        $documentVersionRepositoryMock->expects($this->never())->method('syncTags');
        $attributeValueRepositoryMock = $this->createAttributeValueRepositoryMock();
        $attributeValueRepositoryMock->expects($this->once())->method('save');
        $documentVersionService = new DocumentVersionService(
            $documentVersionRepositoryMock,
            $attributeValueRepositoryMock

        );
        $documentVersion = $this->createDocumentVersion();
        $attibuteValue = new AttributeValue();
        $attibuteValue->setDocumentVersionId(1)->setAttributeId(3)->setValue('rewrfs');
        $documentVersion->setAttributeValues([
            $attibuteValue
        ]);

        $resultDocumentVersion = $documentVersionService->create($documentVersion);

        $this->assertEquals($newId, $resultDocumentVersion->getId());
        $this->assertEquals($newId, $attibuteValue->getDocumentVersionId());
    }

    public function testCreateSyncTagsSuccess()
    {
        $newId = 1;
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('save')->willReturn($newId);
        $documentVersionRepositoryMock->expects($this->never())->method('detachTags');
        $documentVersionRepositoryMock->expects($this->once())->method('syncTags');
        $documentVersionService = new DocumentVersionService(
            $documentVersionRepositoryMock,
            $this->createAttributeValueRepositoryMock()
        );
        $documentVersion = $this->createDocumentVersion();

        $documentVersion->setLabelIds([1,2,3]);
        $resultDocumentVersion = $documentVersionService->create($documentVersion);

        $this->assertEquals($newId, $resultDocumentVersion->getId());
    }

    public function testGetSuccess()
    {
        $documentVersion = $this->createDocumentVersion();

        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('findOrFail')->willReturn($documentVersion);
        $documentVersionService = new DocumentVersionService(
            $documentVersionRepositoryMock,
            $this->createAttributeValueRepositoryMock()
        );

        $result = $documentVersionService->get(1);

        $this->assertEquals($documentVersion, $result);
    }

    public function testGetNotFound()
    {
        $exception = (new ModelNotFoundException)->setModel(DocumentVersion::class);
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->method('findOrFail')->willThrowException($exception);
        $documentVersionService = new DocumentVersionService(
            $documentVersionRepositoryMock,
            $this->createAttributeValueRepositoryMock()
        );

        $this->expectExceptionObject($exception);

        $documentVersionService->get(1);
    }


    public function testDeleteSuccess()
    {
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->expects($this->once())->method('delete');
        $documentVersionService = new DocumentVersionService(
            $documentVersionRepositoryMock,
            $this->createAttributeValueRepositoryMock()
        );

        $documentVersionService->delete(1);
    }

    public function testUpdateSuccess()
    {
        $documentVersionRepositoryMock = $this->createMock(IDocumentVersionRepository::class);
        $documentVersionRepositoryMock->expects($this->once())->method('save');
        $documentVersionService = new DocumentVersionService(
            $documentVersionRepositoryMock,
            $this->createAttributeValueRepositoryMock()
        );

        $documentVersionService->update($this->createDocumentVersion());
    }
}
