<?php

namespace Tests\Feature;

use App\Entities\Label;
use App\Http\Resources\LabelResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
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

        $response->assertStatus(200);
    }

    /**
     * Tests $label get endpoint
     *
     * @return void
     */
    public function testLabelGet()
    {
        $labels = factory(Label::class, 10)->create();

        $response = $this->json('GET', '/api/labels/' . $labels[0]->id);

        $response
            ->assertStatus(200)
            ->assertJson((new LabelResource($labels[0]))->resolve());
    }

    /**
     * Tests label store endpoint
     *
     * @return void
     */
    public function testLabelStore()
    {
        $label = factory(Label::class)->make();

        $response = $this->json('POST', '/api/labels', $label->toArray());

        $label = Label::first();

        $response
            ->assertStatus(201)
            ->assertJson((new LabelResource($label))->resolve());
    }

    /**
     * Tests label update endpoint
     *
     * @return void
     */
    public function testLabelUpdate()
    {
        $label = factory(Label::class)->create();

        $response = $this->json('PUT', '/api/labels/' . $label->id, array_only($label->toArray(), $label->getFillable()));

        $response
            ->assertStatus(200)
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

        $response
            ->assertStatus(204);
    }

}
