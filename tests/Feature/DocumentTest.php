<?php

namespace Tests\Feature;

use App\Entities\Document;
use App\Entities\User;
use Tests\ApiTestCase;
use Tests\Stubs\DocumentStub;

class DocumentTest extends ApiTestCase
{
    private const PATH = 'documents';
    protected const DB_TABLE = 'documents';

    public function testDocumentStoreSuccess()
    {
        $stub = (new DocumentStub())->buildModel();

        $response = $this->json('POST', self::PATH, $stub->buildRequest());
        $responseArray = $response->decodeResponseJson();
        $model = Document::find($responseArray['id']);

        $this->assertExactJson($stub->buildResponse([
            'id' => $model->id
        ]));
    }

    public function testDocumentUpdateSuccess()
    {
        $stub = (new DocumentStub())->buildModel([], true);
        $newOwner = factory(User::class)->create();

        $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $stub->getModel()->id, $stub->buildRequest([
            'owner_id' => $newOwner->id
        ]));

        $this->assertExactJson($stub->buildResponse([
            'id' => $stub->getModel()->id,
            'owner_id' => $newOwner->id,
            'actuablVersion' => [
                'document_id' => 123
            ]
        ]));
    }

    public function testDocumentGetSuccess()
    {
        $stub = (new DocumentStub());
        $model = $stub->buildModel([],true);

        $this->json('GET', $model->id);
        $this->assertExactJson($stub->buildResponse([
            'id' => $model->id
        ]));
    }

    public function testDocumentGetNotFound()
    {
        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
    }


//    public function testUpdateDocumentNoCreateNewVersionSuccess()
//    {
//        $documentVersion = factory(DocumentVersion::class)->create();
//        $attribute = factory(Attribute::class)->create();
//        $tags = factory(Tag::class, 3)->create();
//
//        $newOwner = factory(User::class)->create();
//
//        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $documentVersion->document_id, [
//            'createNewVersion' => false,
//            'ownerId' => $newOwner->id,
//            'actualVersion' => [
//                'name' => 'rename',
//                'templateId' => $documentVersion->template_id,
//                'comment' => $documentVersion->comment,
//                'labelIds' => $tags->pluck('id'),
//                'fileIds' => [],
//                'attributeValues' => [
//                    [
//                        'id' => $attribute->id,
//                        'value' => 'testValue',
//                    ]
//                ],
//            ]
//        ]);
//        $this->assertJsonStructure($response, array_keys(config('models.Document')));
//        $responseArray = $response->decodeResponseJson();
//        $this->assertEquals($newOwner->id, $responseArray['ownerId']);
//        $this->assertEquals('rename', $responseArray['actualVersion']['name']);
//        $this->assertEquals(1, $responseArray['version']);
//        $this->assertNotEmpty($responseArray['actualVersion']['labelIds']);
//        $this->assertNotEmpty($responseArray['actualVersion']['labels']);
//        $this->assertNotEmpty($responseArray['actualVersion']['attributeValues']);
//    }
//
//    public function testDeleteDocumentSuccess()
//    {
//        $documentVersion = factory(DocumentVersion::class)->create();
//        $this->jsonRequestDelete(self::PATH, $documentVersion->document_id, self::DB_TABLE, true);
//    }
//
//    public function testListOfDocumentsWithPaginationSuccess()
//    {
//        factory(DocumentVersion::class, 3)->create();
//
//        $this->jsonRequestObjectsWithPagination(self::PATH);
//    }
//
//    public function testListOfDocumentsWithPaginationWithFiltersSuccess()
//    {
//
//        factory(DocumentVersion::class)->create(['name'=> 'not_match']);
//        factory(DocumentVersion::class)->create(['name'=> 'not_match_1']);
//        factory(DocumentVersion::class)->create(['name'=> 'not_match_2']);
//
//        factory(DocumentVersion::class)->create(['name'=> 'match_1']);
//        factory(DocumentVersion::class)->create(['name'=> 'match_2']);
//
//        $responseArr = $this->jsonRequestObjectsWithPagination(self::PATH . '?filter[name]=match')->decodeResponseJson();
//
//        $this->assertCount(2, $responseArr['data']);
//        $this->assertEquals('match_1', $responseArr['data'][0]['actualVersion']['name']);
//        $this->assertEquals('match_2', $responseArr['data'][1]['actualVersion']['name']);
//    }
//
//    public function testListOfDocumentsWithPaginationWithFiltersTagSuccess()
//    {
//        $tag1 = factory(Tag::class)->create();
//        $tag2 = factory(Tag::class)->create();
//        $tag3 = factory(Tag::class)->create();
//        /** @var DocumentVersion $dv1 */
//        factory(DocumentVersion::class,2)->create();
//        $dv1 = factory(DocumentVersion::class)->create();
//        $dv2 = factory(DocumentVersion::class)->create();
//        $dv3 = factory(DocumentVersion::class)->create();
//
//        $dv1->tags()->sync([$tag2->id]);
//        $dv2->tags()->sync([$tag1->id]);
//        $dv3->tags()->sync([$tag3->id]);
//
//        $responseArr = $this->jsonRequestObjectsWithPagination(self::PATH . '?filter[labelIds]='.$tag1->id.','.$tag2->id)->decodeResponseJson();
//
//        $this->assertCount(2, $responseArr['data']);
//        $this->assertEquals($dv1->id, $responseArr['data'][0]['actualVersion']['id']);
//        $this->assertEquals($dv2->id, $responseArr['data'][1]['actualVersion']['id']);
//    }
//
//    public function testSetActualVersionSuccess()
//    {
//        $documentVersion = factory(DocumentVersion::class)->create();
//        $newDocumentVersion = factory(DocumentVersion::class)->create(['document_id' => $documentVersion->document_id]);
//
//        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $documentVersion->document_id . '/actualVersion', [
//            'versionId' => $newDocumentVersion->id,
//        ]);
//        $this->assertJsonStructure($response, array_keys(config('models.Document')));
//        $responseArray = $response->decodeResponseJson();
//        $this->assertEquals($newDocumentVersion->id, $responseArray['actualVersion']['id']);
//    }
//
//    public function testPatchUpdateDocumentSuccess()
//    {
//        $documentVersion = factory(DocumentVersion::class)->create();
//
//        $newOwner = factory(User::class)->create();
//
//        $response = $this->jsonRequestPatchEntityWithSuccess(self::PATH .'/' . $documentVersion->document_id, [
//            'ownerId' => $newOwner->id,
//        ]);
//
//        $this->assertJsonStructure($response, array_keys(config('models.Document')));
//        $responseArray = $response->decodeResponseJson();
//
//        $this->assertEquals($newOwner->id, $responseArray['ownerId']);
//        $this->assertEquals($documentVersion->id, $responseArray['actualVersion']['id']);
//        $this->assertEquals(1, $responseArray['version']);
//    }
//
//    public function testBulkDeleteDocumentSuccess()
//    {
//        $documentIds = factory(DocumentVersion::class,4)->create()->implode('document.id', ',');
//        $response = $this->jsonRequest('DELETE', self::PATH.'?ids='.$documentIds);
//        $response->assertStatus(204);
//    }
//
//    public function testBulkPatchUpdateDocumentSuccess()
//    {
//        $documentIds = factory(DocumentVersion::class,3)->create()->implode('document.id', ',');
//
//        $newOwner = factory(User::class)->create();
//
//        $response = $this->jsonRequestPatchEntityWithSuccess(self::PATH . '?ids=' . $documentIds, [
//            ['ownerId' => $newOwner->id],
//            ['ownerId' => $newOwner->id],
//            ['ownerId' => $newOwner->id]
//        ]);
//
//        $response->decodeResponseJson();
//
////        $this->assertEquals($newOwner->id, $responseArray['ownerId']);
////        $this->assertEquals($documentVersion->id, $responseArray['actualVersion']['id']);
////        $this->assertEquals(1, $responseArray['version']);
//    }
}
