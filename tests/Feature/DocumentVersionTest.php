<?php

namespace Tests\Feature;

use App\Document;
use App\DocumentVersion;
use Tests\ApiTestCase;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentVersionTest extends ApiTestCase
{
    protected const DB_TABLE = 'document_versions';

    public function testListOfDocumentVersionsWithPaginationSuccess()
    {
        $document = factory(Document::class)->create();
        factory(DocumentVersion::class, 20)->create(['document_id' => $document->id]);

        $response = $this->jsonRequest('GET', 'documents/' . $document->getId() . '/versions');
        $response->assertStatus(200);
    }

    public function testDeleteDocumentVersionSuccess()
    {
        $documentVersion = factory(DocumentVersion::class)->create(['is_actual' => false]);
        $this->jsonRequestDelete('documents/' . $documentVersion->document_id . '/versions', $documentVersion->id, self::DB_TABLE);
    }

    public function testGetDocumentVersionSuccess()
    {
        /** @var DocumentVersion $attribute */
        $dv = factory(DocumentVersion::class)->create();

        $response = $this->jsonRequestGetEntitySuccess('documents/' . $dv->document_id . '/versions/'. $dv->id);

        $this->assertJsonStructure($response, array_keys(config('models.DocumentVersion')));
    }

    public function testGetDocumentVersionNotFound()
    {
        $this->jsonRequestGetEntityNotFound('documents/0/versions/0');
    }
}
