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

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests $template get endpoint
     *
     * @return void
     */
    public function testTemplateGet()
    {
        $templateStub = new TemplateStub([], true);
        $template = $templateStub->getModel();

        $response = $this->json('GET', '/api/templates/' . $template->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($templateStub->buildResponse([
                'id' => $template->id,
                'createdAt' => $template->createdAt->timestamp,
                'updatedAt' => $template->updatedAt->timestamp
            ]));
    }

    /**
     * @throws \Exception
     */
    public function testTemplateStore()
    {
        $templateStub = new TemplateStub();

        $response = $this->json('POST', '/api/templates', $templateStub->buildRequest());

        $template = Template::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertExactJson($templateStub->buildResponse([
                'id' => $template->id,
                'createdAt' => $template->createdAt->timestamp,
                'updatedAt' => $template->updatedAt->timestamp
            ]));
    }

    /**
     * @throws \Exception
     */
    public function testTemplateStoreValidationError()
    {
        $templateStub = new TemplateStub();
        $data = $templateStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);

        $response = $this->json('POST', '/api/templates', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    public function testGetTemplateNotFound()
    {
        $response = $this->json('GET', '/api/templates/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @throws \Exception
     */
    public function testTemplateUpdate()
    {
        $templateStub = new TemplateStub([], true);
        $template = $templateStub->getModel();
        $newTemplateName = 'new template name';

        $response = $this->json('PUT', '/api/templates/' . $template->id, $templateStub->buildRequest([
            'name' => $newTemplateName
        ]));

        $templateUpdated = Template::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($templateStub->buildResponse([
                'id' => $templateUpdated->id,
                'name' => $newTemplateName,
                'createdAt' => $templateUpdated->createdAt->timestamp,
                'updatedAt' => $templateUpdated->updatedAt->timestamp
            ]));
    }

    /**
     * Tests template delete endpoint
     *
     * @return void
     */
    public function testTemplateDelete()
    {
        $templateStub = new TemplateStub([], true);
        $template = $templateStub->getModel();

        $response = $this->json('DELETE', '/api/templates/' . $template->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testTemplateDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', '/api/templates/' . 0);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
