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
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * List of labels
     * @return void
     */
    public function testLabelList()
    {
        factory(Label::class, 10)->create();

        $response = $this
            ->json('GET', self::API_ROOT . 'labels')
            ->assertStatus(Response::HTTP_OK);
        $this->assetJsonPaginationStructure($response);

    }

    /**
     * Get label
     * @return void
     */
    public function testLabelGet()
    {
        $labelStub = new LabelStub([], true);
        $label = $labelStub->getModel();

        $response = $this->json('GET', self::API_ROOT . 'labels/' . $label->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($labelStub->buildResponse());
    }

    /**
     * Save label
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testLabelStore()
    {
        $labelStub = new LabelStub();

        $response = $this->json('POST', self::API_ROOT . 'labels', $labelStub->buildRequest());

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
     * Save label with validation error
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testLabelStoreValidationError()
    {
        $labelStub = new LabelStub();
        $data = $labelStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);

        $response = $this->json('POST', self::API_ROOT . 'labels', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    /**
     * Label not found
     * @return void
     */
    public function testGetLabelNotFound()
    {
        $response = $this->json('GET', self::API_ROOT . 'labels/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Update label
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testLabelUpdate()
    {
        $labelStub = new LabelStub([], true);
        $label = $labelStub->getModel();
        $newLabelName = 'new label name';

        $response = $this->json('PUT', self::API_ROOT . 'labels/' . $label->id, $labelStub->buildRequest([
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
     * Delete label
     * @return void
     */
    public function testLabelDelete()
    {
        $labelStub = new LabelStub([], true);
        $label = $labelStub->getModel();

        $response = $this->json('DELETE', self::API_ROOT . 'labels/' . $label->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete label which does not exist
     * @return void
     */
    public function testLabelDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', self::API_ROOT . 'labels/' . 0);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
