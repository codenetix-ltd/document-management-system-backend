<?php

namespace Tests\Feature;

use App\Entities\Attribute;
use App\Entities\Template;
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
        $response->assertStatus(Response::HTTP_OK);
        $this->assetJsonPaginationStructure($response);
    }

    /**
     * Tests $attribute get endpoint
     *
     * @return void
     */
    public function testAttributeGet()
    {
        $attributeStub = new AttributeWithTypeStringStub([], true);
        $attribute = $attributeStub->getModel();

        $response = $this->json('GET', '/api/templates/' . $attribute->templateId . '/attributes/' . $attribute->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($attributeStub->buildResponse([
                'id' => $attribute->id,
                'createdAt' => $attribute->createdAt->timestamp,
                'updatedAt' => $attribute->updatedAt->timestamp,
            ]));
    }

    /**
     * @throws \Exception
     */
    public function testAttributeStoreTypeString()
    {
        $attributeStub = new AttributeWithTypeStringStub();
        $attribute = $attributeStub->getModel();

        $response = $this->json('POST', '/api/templates/' . $attribute->templateId . '/attributes', $attributeStub->buildRequest());
        $attributeModel = Attribute::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertExactJson($attributeStub->buildResponse([
                'id' => $attributeModel->id,
                'createdAt' => $attributeModel->createdAt->timestamp,
                'updatedAt' => $attributeModel->updatedAt->timestamp,
            ]));
    }

    /**
     * @throws \Exception
     */
    public function testAttributeStoreTypeTable()
    {
        $attributeStub = new AttributeWithTypeTableStub([], false, 'table');
        $attribute = $attributeStub->getModel();

        $response = $this->json('POST', '/api/templates/' . $attribute->templateId . '/attributes', $attributeStub->buildRequest());
        $attributeModel = Attribute::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson($attributeStub->buildResponse([
                'id' => $attributeModel->id,
                'createdAt' => $attributeModel->createdAt->timestamp,
                'updatedAt' => $attributeModel->updatedAt->timestamp,
            ]));
    }

    public function testAttributeStoreValidationError()
    {
        $attributeStub = new AttributeWithTypeStringStub();
        $data = $attributeStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);
        $model = $attributeStub->getModel();

        $response = $this->json('POST', '/api/templates/' . $model->templateId . '/attributes', $data);

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
        $attributeStub = new AttributeWithTypeStringStub([], true);
        $attribute = $attributeStub->getModel();

        $response = $this->json('DELETE', '/api/templates/' . $attribute->templateId . '/attributes/' . $attribute->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testAttributeDeleteWhichDoesNotExist()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('DELETE', '/api/templates/' . $template->id . '/attributes/' . 0);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws \Exception
     */
    public function testAttributeUpdateTypeTable()
    {
        $attributeStub = new AttributeWithTypeTableStub([], false, 'table');
        $attribute = $attributeStub->getModel();

        $response = $this->json('POST', '/api/templates/' . $attribute->templateId . '/attributes', $attributeStub->buildRequest());
        $createdAttribute = $response->decodeResponseJson();

        unset($createdAttribute['data']['rows'][1]);

        $dataForUpdate = $createdAttribute['data'];
        $nameForUpdate = 'new name of attribute';

        $requestData = $attributeStub->buildRequest([
            'name' => $nameForUpdate,
            'typeId' => null
        ]);
        $requestData['data'] = $dataForUpdate;
        $attributeModel = Attribute::find($response->decodeResponseJson('id'));

        $response = $this->json('PUT', '/api/templates/' . $attributeModel->templateId . '/attributes/' . $attributeModel->id, $requestData);

        $stubResponse = $attributeStub->buildResponse([
            'id' => $attributeModel->id,
            'name' => $nameForUpdate,
            'createdAt' => $attributeModel->createdAt->timestamp,
            'updatedAt' => $attributeModel->updatedAt->timestamp
        ]);
        $stubResponse['data'] = $dataForUpdate;

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($stubResponse);
    }


}
