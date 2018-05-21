<?php

namespace Tests\Feature;

use App\Entities\Attribute;
use App\Entities\Template;
use App\Http\Resources\AttributeResource;
use App\Services\AttributeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\AttributeWithTypeStringStub;
use Tests\Stubs\AttributeWithTypeTableStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class AttributeTest extends TestCase
{
    use RefreshDatabase;

    private $attributeService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->attributeService = $this->app->make(AttributeService::class);
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
            'templateId' => $template->id
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
        $template = factory(Template::class)->create();
        $attribute = factory(Attribute::class)->create([
            'templateId' => $template->id
        ]);

        $response = $this->json('GET', '/api/templates/'.$template->id.'/attributes/' . $attribute->id);
        $response
            ->assertStatus(200)
            ->assertJson((new AttributeResource($attribute, $this->attributeService))->resolve());
    }

    /**
     * @throws \Exception
     */
    public function testAttributeStoreTypeString()
    {
        $stub = new AttributeWithTypeStringStub();

        $response = $this->json('POST', '/api/templates/' . $stub->getTemplateId() . '/attributes', $stub->buildRequest());
        $attributeModel = Attribute::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(201)
            ->assertExactJson($stub->buildResponse($attributeModel));
    }

    /**
     * @throws \Exception
     */
    public function testAttributeStoreTypeTable()
    {
        $stub = new AttributeWithTypeTableStub();

        $response = $this->json('POST', '/api/templates/' . $stub->getTemplateId() . '/attributes', $stub->buildRequest());
        $attributeModel = Attribute::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(201)
            ->assertExactJson($stub->buildResponse($attributeModel));
    }

    public function testAttributeStoreValidationError()
    {
        $stub = new AttributeWithTypeStringStub();
        $data = $stub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);

        $response = $this->json('POST', '/api/templates/' . $stub->getTemplateId() . '/attributes', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    public function testGetAttributeNotFound()
    {
        $template = factory(Template::class)->create();
        $response = $this->json('GET', '/api/templates/' . $template->id . '/attributes/' . 0);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests attribute delete endpoint
     *
     * @return void
     */
    public function testAttributeDelete()
    {
        $template = factory(Template::class)->create();
        $attribute = factory(Attribute::class)->create([
            'templateId' => $template->id
        ]);

        $response = $this->json('DELETE', '/api/templates/' . $template->id . '/attributes/' . $attribute->id);
        $response->assertStatus(204);
    }

    public function testAttributeDeleteWhichDoesNotExist()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('DELETE', '/api/templates/' . $template->id . '/attributes/' . 0);
        $response->assertStatus(204);
    }


    /**
     * Tests attribute update endpoint
     *
     * @return void
     */
//    public function testAttributeUpdate()
//    {
//        $attribute = factory(Attribute::class)->create();
//
//        $response = $this->json('PUT', '/api/attributes/' . $attribute->id, array_only($attribute->toArray(), $attribute->getFillable()));
//
//        $response
//            ->assertStatus(200)
//            ->assertJson((new AttributeResource($attribute))->resolve());
//    }


}
