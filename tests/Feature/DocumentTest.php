<?php

namespace Tests\Feature;

use App\Entities\Document;
use App\Entities\DocumentVersion;
use App\Entities\Label;
use App\Entities\Template;
use App\Entities\User;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Stubs\DocumentStub;
use Tests\Stubs\DocumentVersionStub;
use Tests\Stubs\UserStub;

/**
 * Class DocumentTest
 */
class DocumentTest extends TestCase
{
    private const PATH = self::API_ROOT . 'documents';
    protected const DB_TABLE = 'documents';

    /**
     * Setup the test environment.
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Save document
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testDocumentStoreSuccess()
    {
        $stub = new DocumentStub();

        $response = $this->json('POST', self::PATH, $stub->buildRequest());

        $response->assertStatus(Response::HTTP_CREATED);

        $responseArray = $response->decodeResponseJson();

        /** @var Document $model */
        $model = Document::find($responseArray['id']);

        $expectedResponse = $stub->buildResponse([
            'id' => $model->id,
            'createdAt' => $model->createdAt->timestamp,
            'updatedAt' => $model->updatedAt->timestamp,
            'actualVersion' => [
                'id' => $model->documentActualVersion->id,
                'createdAt' => $model->documentActualVersion->createdAt->timestamp,
                'updatedAt' => $model->documentActualVersion->updatedAt->timestamp,
            ],
        ]);

        $response->assertExactJson($expectedResponse);
    }

    /**
     * Update document
     * @return void
     */
    public function testDocumentUpdateSuccess()
    {
        $stub = new DocumentStub([], true);
        /** @var User $newOwner */
        $newOwner = factory(User::class)->create();

        $response = $this->json('PATCH', self::PATH . '/' . $stub->getModel()->id, $stub->buildRequest([
            'ownerId' => $newOwner->id
        ]));

        /** @var Document $updatedDocument */
        $updatedDocument = Document::find($stub->getModel()->id);

        $response->assertExactJson($stub->buildResponse([
            'ownerId' => $newOwner->id,
            'owner' => (new UserStub([], true, [], $newOwner))->buildResponse(),
            'updatedAt' => $updatedDocument->updatedAt->timestamp,
        ]));
    }

    /**
     * Get document
     * @return void
     */
    public function testDocumentGetSuccess()
    {
        $stub = (new DocumentStub([], true));

        $response = $this->json('GET', self::PATH . '/' . $stub->getModel()->id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJson($stub->buildResponse());
    }

    /**
     * List of documents
     * @return void
     */
    public function testListOfDocumentsWithPaginationSortingNameSuccess()
    {
        factory(DocumentVersion::class)->create(['name' => 'abc']);
        /** @var DocumentVersion $dv */
        $dv = factory(DocumentVersion::class)->create(['name' => 'xyz', 'is_actual' => false]);
        factory(DocumentVersion::class)->create(['name' => 'eyz', 'document_id' => $dv->documentId, 'version_name' => 2, 'is_actual' => true]);

        $response = $this->json('GET', self::PATH . '?sort[actualVersion.name]=desc');

        $this->assetJsonPaginationStructure($response);
        $response->assertStatus(Response::HTTP_OK);

        $respArray = $response->decodeResponseJson()['data'];

        $this->assertEquals('eyz', $respArray[0]['actualVersion']['name']);
        $this->assertEquals('abc', $respArray[1]['actualVersion']['name']);
    }

    /**
     * List of documents
     * @return void
     */
    public function testListOfDocumentsWithPaginationSortingOwnerNameSuccess()
    {
        $u1 = factory(User::class)->create(['full_name' => 'abc']);
        $u2 = factory(User::class)->create(['full_name' => 'xyz']);

        (new DocumentStub(['owner_id' => $u1->id], true));
        (new DocumentStub(['owner_id' => $u2->id], true));
        $response = $this->json('GET', self::PATH . '?sort[owner.fullName]=desc');

        $this->assetJsonPaginationStructure($response);
        $response->assertStatus(Response::HTTP_OK);

        $respArray = $response->decodeResponseJson()['data'];

        $this->assertEquals('xyz', $respArray[0]['owner']['fullName']);
        $this->assertEquals('abc', $respArray[1]['owner']['fullName']);
    }

    /**
     * List of documents
     * @return void
     */
    public function testListOfDocumentsWithPaginationSortingVersionTemplateNameSuccess()
    {
        $t1 = factory(Template::class)->create(['name' => 'abc']);
        $t2 = factory(Template::class)->create(['name' => 'xyz']);

        factory(DocumentVersion::class)->create(['template_id' => $t1->id]);
        /** @var DocumentVersion $dv */
        $dv = factory(DocumentVersion::class)->create(['is_actual' => false, 'template_id' => $t1->id]);
        factory(DocumentVersion::class)->create(['document_id' => $dv->documentId, 'version_name' => 2, 'is_actual' => true, 'template_id' => $t2->id]);

        $response = $this->json('GET', self::PATH . '?sort[actualVersion.template.name]=desc');

        $this->assetJsonPaginationStructure($response);
        $response->assertStatus(Response::HTTP_OK);

        $respArray = $response->decodeResponseJson()['data'];

        $this->assertEquals('xyz', $respArray[0]['actualVersion']['template']['name']);
        $this->assertEquals('abc', $respArray[1]['actualVersion']['template']['name']);
    }


    /**
     * Document not found
     * @return void
     */
    public function testDocumentGetNotFound()
    {
        $response = $this->json('GET', self::PATH . '/0');

        $response->assertStatus(404);
    }

    /**
     * Update document without creating new version
     * @return void
     */
    public function testUpdateDocumentNoCreateNewVersionSuccess()
    {
        $documentStub = new DocumentStub([], true);
        /** @var Document $document */
        $document = $documentStub->getModel();
        $oldVersion = $document->documentActualVersion;
        $newDocumentVersionStub = new DocumentVersionStub();

        $response = $this->json('PUT', self::PATH . '/' . $document->id, $documentStub->buildRequest([
            'createNewVersion' => false,
            'actualVersion' => $newDocumentVersionStub->buildRequest()
        ]));

        $response->assertStatus(Response::HTTP_OK);

        /** @var Document $updatedDocument */
        $updatedDocument = Document::find($document->id);
        $savedDocumentVersion = $updatedDocument->documentActualVersion;

        $this->assertCount(1, $updatedDocument->documentVersions);
        $response->assertExactJson($documentStub->buildResponse([
            'updatedAt' => $updatedDocument->updatedAt->timestamp,
            'version' => $oldVersion->versionName,
            'actualVersion' => $newDocumentVersionStub->buildResponse([
                'id' => $savedDocumentVersion->id,
                'updatedAt' => $savedDocumentVersion->updatedAt->timestamp,
                'createdAt' => $savedDocumentVersion->createdAt->timestamp,
            ]),
        ]));
    }

    /**
     * Update document with creating new version
     * @return void
     */
    public function testUpdateDocumentCreateNewVersionSuccess()
    {
        $documentStub = new DocumentStub([], true);
        /** @var Document $document */
        $document = $documentStub->getModel();
        $oldVersion = $document->documentActualVersion;
        $newDocumentVersionStub = new DocumentVersionStub();

        $response = $this->json('PUT', self::PATH . '/' . $document->id, $documentStub->buildRequest([
            'createNewVersion' => true,
            'actualVersion' => $newDocumentVersionStub->buildRequest()
        ]));
        /** @var Document $updatedDocument */
        $updatedDocument = Document::find($document->id);
        $savedDocumentVersion = $updatedDocument->documentActualVersion;

        $response->assertExactJson($documentStub->buildResponse([
            'updatedAt' => $updatedDocument->updatedAt->timestamp,
            'version' => (string)((int)$oldVersion->versionName + 1),
            'actualVersion' => $newDocumentVersionStub->buildResponse([
                'id' => $savedDocumentVersion->id,
                'updatedAt' => $savedDocumentVersion->updatedAt->timestamp,
                'createdAt' => $savedDocumentVersion->createdAt->timestamp,
                'versionName' => $savedDocumentVersion->versionName
            ]),
        ]));

        $this->assertCount(2, $updatedDocument->documentVersions);
    }

    /**
     * Delete document
     * @return void
     */
    public function testDeleteDocumentSuccess()
    {
        /** @var Document $document */
        $document = (new DocumentStub([], true))->getModel();
        $response = $this->json('DELETE', self::PATH . '/' . $document->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSoftDeleted('documents', ['id' => $document->id]);
    }

    /**
     * Delete document which does not exist
     * @return void
     */
    public function testDeleteNotExistDocumentSuccess()
    {
        /** @var Document $document */
        $response = $this->json('DELETE', self::PATH . '/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * List of documents
     * @return void
     */
    public function testListOfDocumentsWithPaginationSuccess()
    {
        factory(DocumentVersion::class, 10)->create();

        $response = $this->json('GET', self::PATH);
        $this->assetJsonPaginationStructure($response);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * List of documents with filters
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testListOfDocumentsWithPaginationWithFiltersSuccess()
    {

        factory(DocumentVersion::class)->create(['name' => 'not_match']);
        factory(DocumentVersion::class)->create(['name' => 'not_match_1']);
        factory(DocumentVersion::class)->create(['name' => 'not_match_2']);

        factory(DocumentVersion::class)->create(['name' => 'match_1']);
        factory(DocumentVersion::class)->create(['name' => 'match_2']);

        $responseArr = $this->json('GET', self::PATH . '?filter[name]=match')->decodeResponseJson();

        $this->assertCount(2, $responseArr['data']);
        $this->assertEquals('match_1', $responseArr['data'][0]['actualVersion']['name']);
        $this->assertEquals('match_2', $responseArr['data'][1]['actualVersion']['name']);
    }

    /**
     * List of documents with filters by label
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testListOfDocumentsWithPaginationWithFiltersLabelSuccess()
    {
        $label1 = factory(Label::class)->create();
        $label2 = factory(Label::class)->create();
        $label3 = factory(Label::class)->create();
        /** @var DocumentVersion $dv1 */
        factory(DocumentVersion::class, 2)->create();
        $dv1 = factory(DocumentVersion::class)->create();
        $dv2 = factory(DocumentVersion::class)->create();
        $dv3 = factory(DocumentVersion::class)->create();

        $dv1->labels()->sync([$label2->id]);
        $dv2->labels()->sync([$label1->id]);
        $dv3->labels()->sync([$label3->id]);

        $response = $this
            ->json('GET', self::PATH . '?filter[labelIds]=' . $label1->id . ',' . $label2->id)
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->decodeResponseJson();

        $this->assertContains($response['data'][0]['actualVersion']['id'], [$dv1->id, $dv2->id]);
        $this->assertContains($response['data'][1]['actualVersion']['id'], [$dv1->id, $dv2->id]);
    }

    /**
     * Update document
     * @return void
     */
    public function testPatchUpdateDocumentSuccess()
    {
        $documentStub = new DocumentStub([], true);
        /** @var Document $document */
        $document = $documentStub->getModel();

        $documentVersionStub = new DocumentVersionStub([
            'document_id' => $document->id,
            'is_actual' => false,
            'version_name' => '42',
        ], true);
        /** @var DocumentVersion $documentVersion */
        $documentVersion = $documentVersionStub->getModel();

        $response = $this->json('PATCH', self::PATH . '/' . $document->id, [
            'actualVersionId' => $documentVersion->id,
        ]);
        /** @var Document $updatedDocument */
        $updatedDocument = Document::find($document->id);

        $response->assertExactJson($documentStub->buildResponse([
            'version' => '42',
            'actualVersion' => $documentVersionStub->buildResponse([
                'updatedAt' => $updatedDocument->documentActualVersion->updatedAt->timestamp
            ]),
            'updatedAt' => $updatedDocument->updatedAt->timestamp
        ]));
    }

    /**
     * Save document with validation error
     * @return void
     */
    public function testDocumentStoreValidationError()
    {
        $stub = new DocumentStub();

        $request = $stub->buildRequest(['substituteDocumentId' => 'string']);
        unset($request['actualVersion']['templateId']);

        $this
            ->json('POST', self::PATH, $request)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['substituteDocumentId', 'actualVersion.templateId']);
    }

    /**
     * Bulk delete
     * @return void
     */
    public function testBulkDeleteDocumentSuccess()
    {
        $docCollection = new Collection();

        for ($i = 0; $i < 3; ++$i) {
            $docCollection->push((new DocumentStub([], true))->getModel());
        }

        $this
            ->json('DELETE', self::PATH . '?ids=' . $docCollection->implode('id', ','))
            ->assertStatus(204);

        $docCollection->each(function (Document $item) {
            $this->assertSoftDeleted('documents', ['id' => $item->id]);
        });
    }

    /**
     * Bulk update
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testBulkPatchUpdateDocumentSuccess()
    {
        $documentsStubCollection = new Collection();

        for ($i = 0; $i < 3; ++$i) {
            $documentsStubCollection->push(new DocumentStub([], true));
        }

        $documentsCollection = $documentsStubCollection->map(function (DocumentStub $item) {
            return $item->getModel();
        });

        /** @var Document $documentSubstitute */
        $documentSubstitute = (new DocumentStub([], true))->getModel();

        $response = $this->json(
            'PATCH',
            self::PATH . '?ids=' . $documentsCollection->implode('id', ','),
            $documentsCollection->map(function () use ($documentSubstitute) {
                return ['substituteDocumentId' => $documentSubstitute->id];
            })->toArray()
        );

        $response->assertStatus(Response::HTTP_OK);

        $expected = $documentsStubCollection->map(function (DocumentStub $item) use ($documentSubstitute) {
            /** @var Document $d */
            $d = $item->getModel();
            $d = Document::find($d->id);
            return $item->buildResponse([
                'substituteDocumentId' => $documentSubstitute->id,
                'updatedAt' => $d->updatedAt->timestamp,
            ]);
        })->toArray();

        $response->assertExactJson($expected);
    }

    /**
     * Bulk update with validation error
     * @return void
     */
    public function testBulkPatchUpdateDocumentFail()
    {
        $response = $this->json(
            'PATCH',
            self::PATH . '?ids=1,2',
            [[], [], []]
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
