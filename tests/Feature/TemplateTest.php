<?php

namespace Tests\Feature;

use App\Template;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class TemplateTest extends TestCase
{
    public const PATH = 'templates';

    public function testCreateUserSuccess()
    {
        $template = factory(Template::class)->make();

        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . self::PATH, [
            'name' => $template->name,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => $template->name,
            ]);
        $this->assertJsonStructure($response);
    }

    public function testCreateTemplateFailName()
    {
        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . self::PATH, []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function testGetTemplateSuccess()
    {
        $template = factory(Template::class)->create();

        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH . '/' .  $template->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $template->name,
            ]);
        $this->assertJsonStructure($response);
    }

    public function testGetTemplateFail()
    {
        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH .'/' . 0);
        $response->assertStatus(404);
    }

    public function testUpdateTemplateSuccess()
    {
        $template = factory(Template::class)->create();
        $templateNameNew = 'New Name';

        $response = $this->actingAs($this->authUser)->json('PUT', self::API_ROOT . self::PATH .'/' . $template->id, [
            'name' => $templateNameNew
        ]);

        $response->assertStatus(200)->assertJson([
            'name' => $templateNameNew,
        ]);
        $this->assertJsonStructure($response);
    }

    public function testDeleteTemplateSuccess()
    {
        $template = factory(Template::class)->create();
        $response = $this->actingAs($this->authUser)->json('DELETE', self::API_ROOT . self::PATH . '/' . $template->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('templates', [
            'id' => $template->id
        ]);
    }

    public function testDeleteTemplateNotExistSuccess()
    {
        $templateId = 0;
        $response = $this->actingAs($this->authUser)->json('DELETE', self::API_ROOT . self::PATH . '/' . $templateId);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('templates', [
            'id' => $templateId
        ]);
    }

    public function testListOfTemplatesWithPaginationSuccess()
    {
        $templates = factory(Template::class, 20)->create();

        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH);
        $response->assertStatus(200);
        $this->assetJsonPaginationStructure($response);
    }

    private function assertJsonStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'id',
            'name',
            'created_at',
            'updated_at'
        ]);
    }
}
