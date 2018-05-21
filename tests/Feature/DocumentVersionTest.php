<?php

namespace Tests\Feature;

use App\Entities\DocumentVersion;
use App\Http\Resources\DocumentVersionCollectionResource;
use App\Http\Resources\DocumentVersionResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class DocumentVersionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();
    }

    /**
     * Tests documentVersion list endpoint
     *
     * @return void
     */
    public function testDocumentVersionList()
    {
        $documentVersions = factory(DocumentVersion::class, 10)->create();

        $response = $this->json('GET', '/api/documentVersions');

        $response
            ->assertStatus(200)
            ->assertJson((new DocumentVersionCollectionResource($documentVersions))->resolve());
    }

    /**
     * Tests $documentVersion get endpoint
     *
     * @return void
     */
    public function testDocumentVersionGet()
    {
        $documentVersions = factory(DocumentVersion::class, 10)->create();

        $response = $this->json('GET', '/api/documentVersions/' . $documentVersions[0]->id);

        $response
            ->assertStatus(200)
            ->assertJson((new DocumentVersionResource($documentVersions[0]))->resolve());
    }

    /**
     * Tests documentVersion store endpoint
     *
     * @return void
     */
    public function testDocumentVersionStore()
    {
        $documentVersion = factory(DocumentVersion::class)->make();

        $response = $this->json('POST', '/api/documentVersions', $documentVersion->toArray());

        $documentVersion = DocumentVersion::first();

        $response
            ->assertStatus(201)
            ->assertJson((new DocumentVersionResource($documentVersion))->resolve());
    }

    /**
     * Tests documentVersion update endpoint
     *
     * @return void
     */
    public function testDocumentVersionUpdate()
    {
        $documentVersion = factory(DocumentVersion::class)->create();

        $response = $this->json('PUT', '/api/documentVersions/' . $documentVersion->id, array_only($documentVersion->toArray(), $documentVersion->getFillable()));

        $response
            ->assertStatus(200)
            ->assertJson((new DocumentVersionResource($documentVersion))->resolve());
    }

    /**
     * Tests documentVersion delete endpoint
     *
     * @return void
     */
    public function testDocumentVersionDelete()
    {
        $documentVersion = factory(DocumentVersion::class)->create();

        $response = $this->json('DELETE', '/api/documentVersions/' . $documentVersion->id);

        $response
            ->assertStatus(204);
    }

}
