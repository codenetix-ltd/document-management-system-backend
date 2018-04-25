<?php

namespace Tests\Feature;

use App\Document;
use App\DocumentVersion;
use Tests\ApiTestCase;

class DocumentTest extends ApiTestCase
{
    private const PATH = 'documents';
    protected const DB_TABLE = 'documents';

    public function testCreateDocumentSuccess()
    {
        $document = factory(Document::class)->make();
        $documentVersion = factory(DocumentVersion::class)->make();

        $response = $this->jsonRequestPostEntityWithSuccess(self::PATH, [
            'ownerId' => $document->owner_id,
            'actualVersion' => [
                'name' => $documentVersion->name,
                'templateId' => $documentVersion->template_id,
                'comment' => $documentVersion->comment,
                'labelIds' => [],
                'fileIds' => [],
                'attributeValues' => [],
            ]
        ]);
//        $response->assertJson([
//            'name' => $tag->name,
//        ]);
//        dd($response->decodeResponseJson());
        $this->assertJsonStructure($response, array_keys(config('models.Document')));
    }
//
//    public function testGetTagSuccess()
//    {
//        $tag = factory(Tag::class)->create();
//
//        $response = $this->jsonRequestGetEntitySuccess(self::PATH . '/' .  $tag->id);
//        $response->assertJson([
//            'name' => $tag->name,
//        ]);
//        $this->assertJsonStructure($response, config('models.tag_response'));
//    }
//
//    public function testGetTagNotFound()
//    {
//        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
//    }
//
//    public function testUpdateTagSuccess()
//    {
//        $tag = factory(Tag::class)->create();
//        $tagNameNew = 'New Name';
//
//        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $tag->id, [
//            'name' => $tagNameNew
//        ]);
//        $response->assertJson([
//            'name' => $tagNameNew
//        ]);
//        $this->assertJsonStructure($response, config('models.tag_response'));
//    }
//
//    public function testDeleteTagSuccess()
//    {
//        $tag = factory(Tag::class)->create();
//        $this->jsonRequestDelete(self::PATH, $tag->id, self::DB_TABLE);
//    }
//
//    public function testDeleteTagNotExistSuccess()
//    {
//        $this->jsonRequestDelete(self::PATH, 0, self::DB_TABLE);
//    }
//
//    public function testListOfTagsWithPaginationSuccess()
//    {
//        factory(Tag::class, 20)->create();
//
//        $this->jsonRequestObjectsWithPagination(self::PATH);
//    }
}
