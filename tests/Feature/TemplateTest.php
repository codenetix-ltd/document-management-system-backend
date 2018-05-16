<?php

namespace Tests\Feature;

use App\Entities\Template;
use App\Http\Resources\TemplateCollectionResource;
use App\Http\Resources\TemplateResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class TemplateTest extends TestCase
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
     * Tests template list endpoint
     *
     * @return void
     */
    public function testTemplateList()
    {
        factory(Template::class, 10)->create();

        $response = $this->json('GET', '/api/templates');

        $this->assetJsonPaginationStructure($response);

        $response->assertStatus(200);
    }

    /**
     * Tests $template get endpoint
     *
     * @return void
     */
    public function testTemplateGet()
    {
        $templates = factory(Template::class, 10)->create();

        $response = $this->json('GET', '/api/templates/' . $templates[0]->id);

        $response
            ->assertStatus(200)
            ->assertJson((new TemplateResource($templates[0]))->resolve());
    }

    /**
     * Tests template store endpoint
     *
     * @return void
     */
    public function testTemplateStore()
    {
        $template = factory(Template::class)->make();

        $response = $this->json('POST', '/api/templates', $template->toArray());
        $template = Template::first();

        $response
            ->assertStatus(201)
            ->assertJson((new TemplateResource($template))->resolve());
    }

    /**
     * Tests template update endpoint
     *
     * @return void
     */
    public function testTemplateUpdate()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('PUT', '/api/templates/' . $template->id, array_only($template->toArray(), $template->getFillable()));

        $response
            ->assertStatus(200)
            ->assertJson((new TemplateResource($template))->resolve());
    }

    /**
     * Tests template delete endpoint
     *
     * @return void
     */
    public function testTemplateDelete()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('DELETE', '/api/templates/' . $template->id);

        $response
            ->assertStatus(204);
    }

}
