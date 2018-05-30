<?php

namespace Tests\Feature;

use App\Entities\Document;
use App\Entities\DocumentVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\DocumentStub;
use Tests\Stubs\DocumentVersionStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class DocumentVersionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();
        $this->actingAs($this->authUser);
    }

    /**
     * Save document version
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testDocumentVersionStore()
    {
        /** @var Document $document */
        $document = (new DocumentStub([], true))->getModel();
        $documentVersionStub = new DocumentVersionStub(['documentId' => $document->id]);

        $response = $this->json('POST', self::API_ROOT . 'documents/' . $document->id . '/documentVersions', $documentVersionStub->buildRequest([]));

        $id = $response->decodeResponseJson()['id'];
        /** @var DocumentVersion $documentVersion */
        $documentVersion = DocumentVersion::find($id);

        $response
            ->assertStatus(201)
            ->assertExactJson($documentVersionStub->buildResponse([
                'id' => $documentVersion->id,
                'createdAt' => $documentVersion->createdAt->timestamp,
                'updatedAt' => $documentVersion->updatedAt->timestamp
            ]));
    }

    /**
     * List of document versions
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testDocumentVersionList()
    {
        /** @var Document $document */
        $document = (new DocumentStub([], true))->getModel();

        for ($i = 0; $i < 3; ++$i) {
            new DocumentVersionStub(['document_id' => $document->id], true);
        }
        new DocumentVersionStub([], true);
        new DocumentVersionStub([], true);


        $response = $this->json('GET', self::API_ROOT . 'documents/' . $document->id . '/documentVersions');

        $this->assetJsonPaginationStructure($response);
        $response->assertStatus(Response::HTTP_OK);

        // 1 from DocumentStub + 3 from loop
        $this->assertCount(4, $response->decodeResponseJson()['data']);
    }

    /**
     * Get document version
     * @return void
     */
    public function testDocumentVersionGet()
    {
        /** @var Document $document */
        $document = (new DocumentStub([], true))->getModel();
        $documentVersionStub = new DocumentVersionStub(['document_id' => $document->id], true);

        /** @var DocumentVersion $documentVersion */
        $documentVersion = $documentVersionStub->getModel();
        $response = $this->json('GET', self::API_ROOT . 'documents/' . $document->id . '/documentVersions/' . $documentVersion->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($documentVersionStub->buildResponse());
    }

    /**
     * Update document version
     * @return void
     */
    public function testDocumentVersionUpdate()
    {
        $documentStub = new DocumentStub([], true);
        /** @var Document $document */
        $document = $documentStub->getModel();
        $documentVersionStub = new DocumentVersionStub(['document_id' => $document->id], true);
        /** @var DocumentVersion $documentVersion */
        $documentVersion = $documentVersionStub->getModel();

        $response = $this->json(
            'PUT',
            self::API_ROOT . 'documents/' . $document->id . '/documentVersions/' . $documentVersion->id,
            $documentVersionStub->buildRequest(['comment' => 'newComment'])
        );
        /** @var DocumentVersion $updatedVersion */
        $updatedVersion = DocumentVersion::find($documentVersion->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($documentVersionStub->buildResponse([
                'updatedAt' => $updatedVersion->updatedAt->timestamp,
                'comment' => 'newComment',
            ]));
    }

    /**
     * Update document version with validation error
     * @return void
     */
    public function testDocumentVersionUpdateValidationError()
    {
        $documentStub = new DocumentStub([], true);
        /** @var Document $document */
        $document = $documentStub->getModel();
        $documentVersionStub = new DocumentVersionStub(['document_id' => $document->id], true);
        /** @var DocumentVersion $documentVersion */
        $documentVersion = $documentVersionStub->getModel();

        $response = $this->json(
            'PUT',
            self::API_ROOT . 'documents/' . $document->id . '/documentVersions/' . $documentVersion->id,
            $documentVersionStub->buildRequest(['comment' => 'newComment', 'name' => null])
        );

        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * Delete document version
     * @return void
     */
    public function testDocumentVersionDelete()
    {
        /** @var Document $document */
        $document = (new DocumentStub([], true))->getModel();
        /** @var DocumentVersion $documentVersion */
        $documentVersion = (new DocumentVersionStub(['document_id' => $document->id], true))->getModel();

        $response = $this->json('DELETE', self::API_ROOT . 'documents/' . $document->id . '/documentVersions/' . $documentVersion->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('document_versions', ['id' => $documentVersion->id]);
    }

    /**
     * Delete document version which does not exist
     * @return void
     */
    public function testDocumentVersionDeleteNotFound()
    {
        $response = $this->json('DELETE', self::API_ROOT . 'documents/0/documentVersions/0');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
