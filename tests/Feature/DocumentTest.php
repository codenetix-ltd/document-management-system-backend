<?php

namespace Tests\Feature;

use App\Entities\Document;
use App\Entities\DocumentVersion;
use App\Entities\Label;
use App\Entities\User;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\ApiTestCase;
use Tests\Stubs\DocumentStub;
use Tests\Stubs\DocumentVersionStub;
use Tests\Stubs\UserStub;

/**
 * Class DocumentTest
 * @package Tests\Feature
 */
class DocumentTest extends ApiTestCase
{
    private const PATH = 'api/documents';
    protected const DB_TABLE = 'documents';

    public function setUp()
    {
        parent::setUp();
        $this->actingAs($this->authUser);
    }

    public function testDocumentStoreSuccess()
    {
        $stub = new DocumentStub();

        $response = $this->json('POST', self::PATH, $stub->buildRequest());
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

    public function testDocumentUpdateSuccess()
    {
        $stub = new DocumentStub([], true);
        /** @var User $newOwner */
        $newOwner = factory(User::class)->create();

        $response = $this->json('PATCH',self::PATH .'/' . $stub->getModel()->id, $stub->buildRequest([
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

    public function testDocumentGetSuccess()
    {
        $stub = (new DocumentStub([], true));

        $response = $this->json('GET', self::PATH .'/' . $stub->getModel()->id);

        $response->assertExactJson($stub->buildResponse());
    }

    public function testDocumentGetNotFound()
    {
        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
    }


    public function testUpdateDocumentNoCreateNewVersionSuccess()
    {
        $documentStub = new DocumentStub([], true);
        /** @var Document $document */
        $document = $documentStub->getModel();
        $oldVersion = $document->documentActualVersion;
        $newDocumentVersionStub = new DocumentVersionStub();

        $response = $this->json('PUT',self::PATH .'/' . $document->id, $documentStub->buildRequest([
            'createNewVersion' => false,
            'actualVersion' => $newDocumentVersionStub->buildRequest()
        ]));
        /** @var Document $updatedDocument */
        $updatedDocument = Document::find($document->id);
        $savedDocumentVersion = $updatedDocument->documentActualVersion;

        $response->assertExactJson($documentStub->buildResponse([
            'updatedAt' => $updatedDocument->updatedAt->timestamp,
            'version' => $oldVersion->versionName,
            'actualVersion' => $newDocumentVersionStub->buildResponse([
                'id' => $savedDocumentVersion->id,
                'updatedAt' => $savedDocumentVersion->updatedAt->timestamp,
                'createdAt' => $savedDocumentVersion->createdAt->timestamp,
            ]),
        ]));

        $this->assertCount(1, $updatedDocument->documentVersions);
    }

    public function testUpdateDocumentCreateNewVersionSuccess()
    {
        $documentStub = new DocumentStub([], true);
        /** @var Document $document */
        $document = $documentStub->getModel();
        $oldVersion = $document->documentActualVersion;
        $newDocumentVersionStub = new DocumentVersionStub();

        $response = $this->json('PUT',self::PATH .'/' . $document->id, $documentStub->buildRequest([
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
            ]),
        ]));

        $this->assertCount(2, $updatedDocument->documentVersions);

    }
//
    public function testDeleteDocumentSuccess()
    {
        /** @var Document $document */
        $document = (new DocumentVersionStub([], true))->getModel();
        $response = $this->json('DELETE', self::PATH . '/' . $document->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSoftDeleted('documents', ['id' => $document->id]);
    }

    public function testDeleteNotExistDocumentSuccess()
    {
        /** @var Document $document */
        $response = $this->json('DELETE', self::PATH . '/' . 0);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testListOfDocumentsWithPaginationSuccess()
    {
        factory(DocumentVersion::class, 10)->create();

        $response = $this->json('GET', self::PATH);
        $this->assetJsonPaginationStructure($response);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testListOfDocumentsWithPaginationWithFiltersSuccess()
    {

        factory(DocumentVersion::class)->create(['name'=> 'not_match']);
        factory(DocumentVersion::class)->create(['name'=> 'not_match_1']);
        factory(DocumentVersion::class)->create(['name'=> 'not_match_2']);

        factory(DocumentVersion::class)->create(['name'=> 'match_1']);
        factory(DocumentVersion::class)->create(['name'=> 'match_2']);

        $responseArr = $this->json('GET',self::PATH . '?filters[name]=match')->decodeResponseJson();

        $this->assertCount(2, $responseArr['data']);
        $this->assertEquals('match_1', $responseArr['data'][0]['actualVersion']['name']);
        $this->assertEquals('match_2', $responseArr['data'][1]['actualVersion']['name']);
    }

    public function testListOfDocumentsWithPaginationWithFiltersLabelSuccess()
    {
        $tag1 = factory(Label::class)->create();
        $tag2 = factory(Label::class)->create();
        $tag3 = factory(Label::class)->create();
        /** @var DocumentVersion $dv1 */
        factory(DocumentVersion::class,2)->create();
        $dv1 = factory(DocumentVersion::class)->create();
        $dv2 = factory(DocumentVersion::class)->create();
        $dv3 = factory(DocumentVersion::class)->create();

        $dv1->labels()->sync([$tag2->id]);
        $dv2->labels()->sync([$tag1->id]);
        $dv3->labels()->sync([$tag3->id]);

        $responseArr = $this->json('GET', self::PATH . '?filters[labelIds]='.$tag1->id.','.$tag2->id)->decodeResponseJson();

        $this->assertCount(2, $responseArr['data']);
        $this->assertEquals($dv1->id, $responseArr['data'][0]['actualVersion']['id']);
        $this->assertEquals($dv2->id, $responseArr['data'][1]['actualVersion']['id']);
    }

    public function testPatchUpdateDocumentSuccess()
    {
        $documentStub = new DocumentStub([],true);
        /** @var Document $document */
        $document = $documentStub->getModel();

        $documentVersionStub = new DocumentVersionStub([
            'document_id' => $document->id,
            'is_actual' => false,
            'version_name' => '42',
        ], true);
        /** @var DocumentVersion $documentVersion */
        $documentVersion = $documentVersionStub->getModel();

        $response = $this->json('PATCH', self::PATH .'/' . $document->id, [
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
     * @throws \Exception
     */
    public function testDocumentStoreValidationError()
    {
        $stub = new DocumentStub();

        $request = $stub->buildRequest(['substituteDocumentId' => 'string']);
        unset($request['actualVersion']['templateId']);

        $response = $this->json('POST', self::PATH, $request);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['substituteDocumentId', 'actualVersion.templateId']);
    }

    public function testBulkDeleteDocumentSuccess()
    {
        $docCollection = new Collection();

        for($i=0;$i<3;++$i) {
            $docCollection->push((new DocumentStub([], true))->getModel());
        }

        $response = $this->json('DELETE', self::PATH.'?ids='.$docCollection->implode('id', ','));
        $response->assertStatus(204);

        $docCollection->each(function(Document $item){
            $this->assertSoftDeleted('documents', ['id' => $item->id]);
        });
    }

    public function testBulkPatchUpdateDocumentSuccess()
    {
        $documentsStubCollection = new Collection();

        for($i=0;$i<3;++$i) {
            $documentsStubCollection->push(new DocumentStub([], true));
        }

        $documentsCollection = $documentsStubCollection->map(function(DocumentStub $item){
            return $item->getModel();
        });

        /** @var Document $documentSubstitute */
        $documentSubstitute = (new DocumentStub([], true))->getModel();

        $response = $this->json(
            'PATCH',
            self::PATH . '?ids=' . $documentsCollection->implode('id', ','),
            $documentsCollection->map(function()use($documentSubstitute){
                return ['substituteDocumentId' => $documentSubstitute->id];
            })->toArray()
        );

        $response->decodeResponseJson();

        $expected = $documentsStubCollection->map(function(DocumentStub $item)use ($documentSubstitute){
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
}
