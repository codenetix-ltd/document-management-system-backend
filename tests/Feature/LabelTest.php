<?php

namespace Tests\Feature;

use App\Entities\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\LabelStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class LabelTest extends TestCase
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
        $this->actingAs($this->authUser);
    }

    /**
     * Tests label list endpoint
     *
     * @return void
     */
    public function testLabelList()
    {
        factory(Label::class, 10)->create();

        $response = $this->json('GET', '/api/labels');
        $this->assetJsonPaginationStructure($response);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests $label get endpoint
     *
     * @return void
     */
    public function testLabelGet()
    {
        $labelStub = new LabelStub([], true);
        $label = $labelStub->getModel();

        $response = $this->json('GET', '/api/labels/' . $label->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($labelStub->buildResponse());
    }

    /**
     * @throws \Exception
     */
    public function testLabelStore()
    {
        $labelStub = new LabelStub();

        $response = $this->json('POST', '/api/labels', $labelStub->buildRequest());

        /** @var Label $label */
        $label = Label::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertExactJson($labelStub->buildResponse([
                'id' => $label->id,
                'createdAt' => $label->createdAt->timestamp,
                'updatedAt' => $label->updatedAt->timestamp
            ]));
    }

    /**
     * @throws \Exception
     */
    public function testLabelStoreValidationError()
    {
        $labelStub = new LabelStub();
        $data = $labelStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);

        $response = $this->json('POST', '/api/labels', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    public function testGetLabelNotFound()
    {
        $response = $this->json('GET', '/api/labels/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @throws \Exception
     */
    public function testLabelUpdate()
    {
        $labelStub = new LabelStub([], true);
        $label = $labelStub->getModel();
        $newLabelName = 'new label name';

        $response = $this->json('PUT', '/api/labels/' . $label->id, $labelStub->buildRequest([
            'name' => $newLabelName
        ]));

        /** @var Label $labelUpdated */
        $labelUpdated = Label::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($labelStub->buildResponse([
                'name' => $newLabelName,
                'updatedAt' => $labelUpdated->updatedAt->timestamp
            ]));
    }

    /**
     * Tests label delete endpoint
     *
     * @return void
     */
    public function testLabelDelete()
    {
        $labelStub = new LabelStub([], true);
        $label = $labelStub->getModel();

        $response = $this->json('DELETE', '/api/labels/' . $label->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testLabelDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', '/api/labels/' . 0);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

}
