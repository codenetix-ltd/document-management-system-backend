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
            'createNewVersion' => true,
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

    public function testListOfDocumentsWithPaginationWithFiltersSuccess()
    {

        factory(DocumentVersion::class)->create(['name'=> 'not_match']);
        factory(DocumentVersion::class)->create(['name'=> 'not_match_1']);
        factory(DocumentVersion::class)->create(['name'=> 'not_match_2']);

        factory(DocumentVersion::class)->create(['name'=> 'match_1']);
        factory(DocumentVersion::class)->create(['name'=> 'match_2']);

        $responseArr = $this->jsonRequestObjectsWithPagination(self::PATH . '?filter[name]=match');

        $this->assertCount(2, $responseArr['data']);
        $this->assertEquals('match_1', $responseArr['data'][0]['actualVersion']['name']);
        $this->assertEquals('match_2', $responseArr['data'][1]['actualVersion']['name']);
    }

    public function testListOfDocumentsWithPaginationWithFiltersTagSuccess()
    {
        $tag1 = factory(Tag::class)->create();
        $tag2 = factory(Tag::class)->create();
        $tag3 = factory(Tag::class)->create();
        /** @var DocumentVersion $dv1 */
        factory(DocumentVersion::class,2)->create();
        $dv1 = factory(DocumentVersion::class)->create();
        $dv2 = factory(DocumentVersion::class)->create();
        $dv3 = factory(DocumentVersion::class)->create();

        $dv1->tags()->sync([$tag2->id]);
        $dv2->tags()->sync([$tag1->id]);
        $dv3->tags()->sync([$tag3->id]);

        $responseArr = $this->jsonRequestObjectsWithPagination(self::PATH . '?filter[labelIds]='.$tag1->id.','.$tag2->id);

        $this->assertCount(2, $responseArr['data']);
        $this->assertEquals($dv1->id, $responseArr['data'][0]['actualVersion']['id']);
        $this->assertEquals($dv2->id, $responseArr['data'][1]['actualVersion']['id']);
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

    public function testPatchUpdateDocumentSuccess()
    {
        $documentVersion = factory(DocumentVersion::class)->create();

        $newOwner = factory(User::class)->create();

        $response = $this->jsonRequestPatchEntityWithSuccess(self::PATH .'/' . $documentVersion->document_id, [
            'ownerId' => $newOwner->id,
        ]);

        $this->assertJsonStructure($response, array_keys(config('models.Document')));
        $responseArray = $response->decodeResponseJson();

        $this->assertEquals($newOwner->id, $responseArray['ownerId']);
        $this->assertEquals($documentVersion->id, $responseArray['actualVersion']['id']);
        $this->assertEquals(1, $responseArray['version']);
    }

    public function testBulkDeleteDocumentSuccess()
    {
        $documentIds = factory(DocumentVersion::class,4)->create()->implode('document.id', ',');
        $response = $this->jsonRequest('DELETE', self::PATH.'?ids='.$documentIds);
        $response->assertStatus(204);
    }
}
