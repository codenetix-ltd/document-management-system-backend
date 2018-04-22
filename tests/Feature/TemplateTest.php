<?php

namespace Tests\Feature;

use App\Attribute;
use App\Template;
use Tests\ApiTestCase;

class TemplateTest extends ApiTestCase
{
    private const PATH = 'templates';
    private const DB_TABLE = 'templates';

    public function testCreateTemplateSuccess()
    {
        $template = factory(Template::class)->make();

        $response = $this->jsonRequestPostEntityWithSuccess(self::PATH, [
            'name' => $template->name,
        ]);
        $this->assertJsonStructure($response, config('models.template_response'));
    }

    public function testGetTemplateSuccess()
    {
        $template = factory(Template::class)->create();
        $attribute = factory(Attribute::class)->create();
        $template->attributes()->save($attribute);

        $response = $this->jsonRequestGetEntitySuccess(self::PATH . '/' .  $template->id);
        $response->assertJson([
            'name' => $template->name,
        ]);
        $this->assertJsonStructure($response, config('models.template_response'));
    }

    public function testGetTemplateNotFound()
    {
        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
    }

    public function testUpdateTemplateSuccess()
    {
        $template = factory(Template::class)->create();
        $templateNameNew = 'New Name';

        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $template->id, [
            'name' => $templateNameNew
        ]);
        $response->assertJson([
            'name' => $templateNameNew
        ]);
        $this->assertJsonStructure($response, config('models.template_response'));
    }

    public function testDeleteTagSuccess()
    {
        $template = factory(Template::class)->create();
        $this->jsonRequestDelete(self::PATH, $template->id, self::DB_TABLE);
    }

    public function testDeleteTagNotExistSuccess()
    {
        $this->jsonRequestDelete(self::PATH, 0, self::DB_TABLE);
    }

    public function testListOfTemplatesWithPaginationSuccess()
    {
        factory(Template::class, 20)->create();

        $this->jsonRequestObjectsWithPagination(self::PATH);
    }
}
