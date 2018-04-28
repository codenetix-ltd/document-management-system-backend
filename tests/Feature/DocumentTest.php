<?php

namespace Tests\Feature;

use App\Attribute;
use App\Document;
use App\DocumentVersion;
use App\File;
use App\Tag;
use App\User;
use Tests\ApiTestCase;

class DocumentTest extends ApiTestCase
{
    private const PATH = 'documents';
    protected const DB_TABLE = 'documents';

    public function testCreateDocumentSuccess()
    {
        $document = factory(Document::class)->make();
        $documentVersion = factory(DocumentVersion::class)->make();
        $attribute = factory(Attribute::class)->create();
        $tags = factory(Tag::class, 3)->create();
        $files = factory(File::class, 3)->create();

        $response = $this->jsonRequestPostEntityWithSuccess(self::PATH, [
            'ownerId' => $document->owner_id,
            'actualVersion' => [
                'name' => $documentVersion->name,
                'templateId' => $documentVersion->template_id,
                'comment' => $documentVersion->comment,
                'labelIds' => $tags->pluck('id'),
                'fileIds' => $files->pluck('id'),
                'attributeValues' => [
                    [
                        'id' => $attribute->id,
                        'value' => 'testValue',
                    ]
                ],
            ]
        ]);
        $this->assertJsonStructure($response, array_keys(config('models.Document')));
        $responseArray = $response->decodeResponseJson();
        $this->assertNotEmpty($responseArray['actualVersion']['labelIds']);
        $this->assertNotEmpty($responseArray['actualVersion']['labels']);
        $this->assertNotEmpty($responseArray['actualVersion']['attributeValues']);
        $this->assertNotEmpty($responseArray['actualVersion']['files']);
    }

    public function testGetDocumentSuccess()
    {
        /** @var DocumentVersion $document */
        $documentVersion = factory(DocumentVersion::class)->create();

        $response = $this->jsonRequestGetEntitySuccess(self::PATH . '/' .  $documentVersion->document_id);

        $this->assertJsonStructure($response, array_keys(config('models.Document')));
    }

    public function testGetDocumentNotFound()
    {
        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
    }

    public function testUpdateDocumentSuccess()
    {
        $documentVersion = factory(DocumentVersion::class)->create();
        $attribute = factory(Attribute::class)->create();
        $tags = factory(Tag::class, 3)->create();

        $newOwner = factory(User::class)->create();

        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $documentVersion->document_id, [
            'ownerId' => $newOwner->id,
            'actualVersion' => [
                'name' => 'rename',
                'templateId' => $documentVersion->template_id,
                'comment' => $documentVersion->comment,
                'labelIds' => $tags->pluck('id'),
                'fileIds' => [],
                'attributeValues' => [
                    [
                        'id' => $attribute->id,
                        'value' => 'testValue',
                    ]
                ],
            ]
        ]);
        $this->assertJsonStructure($response, array_keys(config('models.Document')));
        $responseArray = $response->decodeResponseJson();
        $this->assertEquals($newOwner->id, $responseArray['ownerId']);
        $this->assertEquals('rename', $responseArray['actualVersion']['name']);
        $this->assertNotEquals($documentVersion->id, $responseArray['actualVersion']['id']);
        $this->assertEquals(2, $responseArray['version']);
        $this->assertNotEmpty($responseArray['actualVersion']['labelIds']);
        $this->assertNotEmpty($responseArray['actualVersion']['labels']);
        $this->assertNotEmpty($responseArray['actualVersion']['attributeValues']);
    }

    public function testUpdateDocumentNoCreateNewVersionSuccess()
    {
        $documentVersion = factory(DocumentVersion::class)->create();
        $attribute = factory(Attribute::class)->create();
        $tags = factory(Tag::class, 3)->create();

        $newOwner = factory(User::class)->create();

        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $documentVersion->document_id, [
            'createNewVersion' => false,
            'ownerId' => $newOwner->id,
            'actualVersion' => [
                'name' => 'rename',
                'templateId' => $documentVersion->template_id,
                'comment' => $documentVersion->comment,
                'labelIds' => $tags->pluck('id'),
                'fileIds' => [],
                'attributeValues' => [
                    [
                        'id' => $attribute->id,
                        'value' => 'testValue',
                    ]
                ],
            ]
        ]);
        $this->assertJsonStructure($response, array_keys(config('models.Document')));
        $responseArray = $response->decodeResponseJson();
        $this->assertEquals($newOwner->id, $responseArray['ownerId']);
        $this->assertEquals('rename', $responseArray['actualVersion']['name']);
        $this->assertEquals(1, $responseArray['version']);
        $this->assertNotEmpty($responseArray['actualVersion']['labelIds']);
        $this->assertNotEmpty($responseArray['actualVersion']['labels']);
        $this->assertNotEmpty($responseArray['actualVersion']['attributeValues']);
    }

    public function testDeleteDocumentSuccess()
    {
        $documentVersion = factory(DocumentVersion::class)->create();
        $this->jsonRequestDelete(self::PATH, $documentVersion->document_id, self::DB_TABLE, true);
    }

    public function testListOfDocumentsWithPaginationSuccess()
    {
        factory(DocumentVersion::class, 3)->create();

        $this->jsonRequestObjectsWithPagination(self::PATH);
    }

    public function testSetActualVersionSuccess()
    {
        $documentVersion = factory(DocumentVersion::class)->create();
        $newDocumentVersion = factory(DocumentVersion::class)->create(['document_id' => $documentVersion->document_id]);

        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $documentVersion->document_id . '/actualVersion', [
            'versionId' => $newDocumentVersion->id,
        ]);
        $this->assertJsonStructure($response, array_keys(config('models.Document')));
        $responseArray = $response->decodeResponseJson();
        $this->assertEquals($newDocumentVersion->id, $responseArray['actualVersion']['id']);
    }
}
