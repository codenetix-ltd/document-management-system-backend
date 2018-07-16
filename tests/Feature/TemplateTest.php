<?php

namespace Tests\Feature;

use App\Entities\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\TemplateStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class TemplateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();
    }

    /**
     * List of templates
     * @return void
     */
    public function testTemplateList()
    {
        factory(Template::class, 10)->create();

        $response = $this->json('GET', self::API_ROOT . 'templates');
        $this->assetJsonPaginationStructure($response);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Get template
     * @return void
     */
    public function testTemplateGet()
    {
        $templateStub = new TemplateStub([], true);
        $template = $templateStub->getModel();

        $response = $this->json('GET', self::API_ROOT . 'templates/' . $template->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($templateStub->buildResponse());
    }

    /**
     * Save template
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testTemplateStore()
    {
        $templateStub = new TemplateStub([], false, [], null, false);

        $response = $this->json('POST', self::API_ROOT . 'templates', $templateStub->buildRequest());

        $template = Template::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertExactJson($templateStub->buildResponse([
                'id' => $template->id,
                'createdAt' => $template->createdAt->timestamp,
                'updatedAt' => $template->updatedAt->timestamp,
            ]));
    }

    /**
     * Save template with validation error
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testTemplateStoreValidationError()
    {
        $templateStub = new TemplateStub();
        $data = $templateStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);

        $response = $this->json('POST', self::API_ROOT . 'templates', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    /**
     * Template not found
     * @return void
     */
    public function testGetTemplateNotFound()
    {
        $response = $this->json('GET', self::API_ROOT . 'templates/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Update template
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testTemplateUpdate()
    {
        $templateStub = new TemplateStub([], true);

        $template = $templateStub->getModel();
        $newTemplateName = 'new template name';

        $response = $this->json('PUT', self::API_ROOT . 'templates/' . $template->id, $templateStub->buildRequest([
            'name' => $newTemplateName,
            'orderOfAttributes' => array_reverse($template->attributes->pluck('id')->toArray())
        ]));

        $templateUpdated = Template::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($templateStub->buildResponse([
                'id' => $templateUpdated->id,
                'name' => $newTemplateName,
                'createdAt' => $templateUpdated->createdAt->timestamp,
                'updatedAt' => $templateUpdated->updatedAt->timestamp,
                'attributes' => $response->decodeResponseJson('attributes')
            ]));
    }

    /**
     * Delete template
     * @return void
     */
    public function testTemplateDelete()
    {
        $templateStub = new TemplateStub([], true);
        $template = $templateStub->getModel();

        $response = $this->json('DELETE', self::API_ROOT . 'templates/' . $template->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete role which does not exist
     * @return void
     */
    public function testTemplateDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', self::API_ROOT . 'templates/' . 0);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
