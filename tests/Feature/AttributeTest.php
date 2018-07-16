<?php

namespace Tests\Feature;

use App\Entities\Attribute;
use App\Entities\Template;
use App\Services\AttributeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\Stubs\AttributeWithTypeStringStub;
use Tests\Stubs\AttributeWithTypeTableStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class AttributeTest extends TestCase
{
    use RefreshDatabase;

    /** @var AttributeService $attributeService*/
    private $attributeService;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->attributeService = $this->app->make(AttributeService::class);
        Resource::withoutWrapping();
    }

    /**
     * List of attributes
     * @return void
     */
    public function testAttributeList()
    {
        $template = factory(Template::class)->create();
        factory(Attribute::class, 10)->create([
            'templateId' => $template->id
        ]);

        $response = $this->json('GET', self::API_ROOT . 'templates/' . $template->id . '/attributes');
        $response->assertStatus(Response::HTTP_OK);
        $this->assetJsonPaginationStructure($response);
    }

    /**
     * Get attribute
     * @return void
     */
    public function testAttributeGet()
    {
        $attributeStub = new AttributeWithTypeStringStub([], true);
        $attribute = $attributeStub->getModel();

        $response = $this->json('GET', self::API_ROOT . 'templates/' . $attribute->templateId . '/attributes/' . $attribute->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($attributeStub->buildResponse([
                'id' => $attribute->id,
                'createdAt' => $attribute->createdAt->timestamp,
                'updatedAt' => $attribute->updatedAt->timestamp,
            ]));
    }

    /**
     * Save attribute with string type
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testAttributeStoreTypeString()
    {
        $attributeStub = new AttributeWithTypeStringStub();
        $attribute = $attributeStub->getModel();

        $response = $this->json('POST', self::API_ROOT . 'templates/' . $attribute->templateId . '/attributes', $attributeStub->buildRequest());
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
     * Save attribute with table type
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testAttributeStoreTypeTable()
    {
        $attributeStub = new AttributeWithTypeTableStub([], false, ['table']);
        $attribute = $attributeStub->getModel();

        $response = $this->json('POST', self::API_ROOT . 'templates/' . $attribute->templateId . '/attributes', $attributeStub->buildRequest());
        $attributeModel = Attribute::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson($attributeStub->buildResponse([
                'id' => $attributeModel->id,
                'createdAt' => $attributeModel->createdAt->timestamp,
                'updatedAt' => $attributeModel->updatedAt->timestamp,
            ]));
    }

    /**
     * Save attribute with validation error
     * @return void
     */
    public function testAttributeStoreValidationError()
    {
        $attributeStub = new AttributeWithTypeStringStub();
        $data = $attributeStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);
        $model = $attributeStub->getModel();

        $response = $this->json('POST', self::API_ROOT . 'templates/' . $model->templateId . '/attributes', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    /**
     * Attribute not found
     * @return void
     */
    public function testGetAttributeNotFound()
    {
        $template = factory(Template::class)->create();
        $response = $this->json('GET', self::API_ROOT . 'templates/' . $template->id . '/attributes/' . 0);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Delete attribute
     * @return void
     */
    public function testAttributeDelete()
    {
        $attributeStub = new AttributeWithTypeStringStub([], true);
        $attribute = $attributeStub->getModel();

        $response = $this->json('DELETE', self::API_ROOT . 'templates/' . $attribute->templateId . '/attributes/' . $attribute->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete attribute which does not exist
     * @return void
     */
    public function testAttributeDeleteWhichDoesNotExist()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('DELETE', self::API_ROOT . 'templates/' . $template->id . '/attributes/' . 0);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Update attribute with table type
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testAttributeUpdateTypeTable()
    {
        $attributeStub = new AttributeWithTypeTableStub([], false, ['table']);
        $attribute = $attributeStub->getModel();

        $response = $this->json('POST', self::API_ROOT . 'templates/' . $attribute->templateId . '/attributes', $attributeStub->buildRequest());
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

        $response = $this->json('PUT', self::API_ROOT . 'templates/' . $attributeModel->templateId . '/attributes/' . $attributeModel->id, $requestData);

        $stubResponse = $attributeStub->buildResponse([
            'id' => $attributeModel->id,
            'name' => $nameForUpdate,
            'createdAt' => $response->decodeResponseJson('createdAt'),
            'updatedAt' => $response->decodeResponseJson('updatedAt')
        ]);
        $stubResponse['data'] = $dataForUpdate;

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($stubResponse);
    }
}
