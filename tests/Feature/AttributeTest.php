<?php

namespace Tests\Feature;

use App\Entities\Attribute;
use App\Entities\Template;
use App\Http\Resources\AttributeCollectionResource;
use App\Http\Resources\AttributeResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Tests\Stubs\Requests\AttributeStoreRequestStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class AttributeTest extends TestCase
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
     * Tests attribute list endpoint
     *
     * @return void
     */
    public function testAttributeList()
    {
        $template = factory(Template::class)->create();

        factory(Attribute::class, 10)->create([
            'template_id' => $template->id
        ]);

        $response = $this->json('GET', '/api/templates/' . $template->id . '/attributes');

        $response->assertStatus(200);
        $this->assetJsonPaginationStructure($response);
    }

    /**
     * Tests $attribute get endpoint
     *
     * @return void
     */
    public function testAttributeGet()
    {
        $attributes = factory(Attribute::class, 10)->create();

        $response = $this->json('GET', '/api/attributes/' . $attributes[0]->id);

        $response
            ->assertStatus(200)
            ->assertJson((new AttributeResource($attributes[0]))->resolve());
    }

    /**
     * Tests attribute store endpoint
     *
     * @return void
     */
    public function testAttributeStoreTypeString()
    {
        $stub = (new AttributeStoreRequestStub())->buildAttributeWithTypeString();

        $response = $this->json('POST', '/api/templates/' . $stub['templateId'] . '/attributes', $stub['attribute']);
        $response->dump();

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => $stub['attribute']['name'],
                'templateId' => $stub['templateId'],
                'typeId' => $stub['attribute']['typeId'],
                'isLocked' => false,
                'order' => 0
            ]);
    }









    /**
     * Tests attribute update endpoint
     *
     * @return void
     */
    public function testAttributeUpdate()
    {
        $attribute = factory(Attribute::class)->create();

        $response = $this->json('PUT', '/api/attributes/' . $attribute->id, array_only($attribute->toArray(), $attribute->getFillable()));

        $response
            ->assertStatus(200)
            ->assertJson((new AttributeResource($attribute))->resolve());
    }

    /**
     * Tests attribute delete endpoint
     *
     * @return void
     */
    public function testAttributeDelete()
    {
        $attribute = factory(Attribute::class)->create();

        $response = $this->json('DELETE', '/api/attributes/' . $attribute->id);

        $response
            ->assertStatus(204);
    }

}
