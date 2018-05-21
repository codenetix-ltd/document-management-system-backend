<?php

namespace Tests\Feature;

use App\Entities\Label;
use App\Http\Resources\LabelResource;
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
        $label = factory(Label::class)->create();

        $response = $this->json('GET', '/api/labels/' . $label->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson((new LabelResource($label))->resolve());
    }

    /**
     * @throws \Exception
     */
    public function testLabelStore()
    {
        $labelStub = new LabelStub();

        $response = $this->json('POST', '/api/labels', $labelStub->buildRequest());

        $label = Label::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson($labelStub->buildResponse($label));
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
     * Tests label update endpoint
     *
     * @return void
     */
    public function testLabelUpdate()
    {
        //$labelStub = new LabelStub();

        $response = $this->json('PUT', '/api/labels/' . $label->id, array_only($label->toArray(), $label->getFillable()));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson((new LabelResource($label))->resolve());
    }

    /**
     * Tests label delete endpoint
     *
     * @return void
     */
    public function testLabelDelete()
    {
        $label = factory(Label::class)->create();

        $response = $this->json('DELETE', '/api/labels/' . $label->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testLabelDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', '/api/labels/' . 0);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

}
