<?php

namespace Tests\Feature;

use App\Tag;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class TagTest extends TestCase
{
    public const PATH = 'tags';

    public function testCreateTagSuccess()
    {
        //TODO - создать свою фабрику, где можно было бы получать модели по интерфейсу а не по классу напрямую
        $tag = factory(Tag::class)->make();

        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . self::PATH, [
            'name' => $tag->name,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => $tag->name,
            ]);
        $this->assertJsonStructure($response);
    }

    public function testCreateTagFailName()
    {
        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . self::PATH, []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function testGetTagSuccess()
    {
        $tag = factory(Tag::class)->create();

        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH . '/' .  $tag->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $tag->name,
            ]);
        $this->assertJsonStructure($response);
    }

    //TODO - убрать отсюда типичные тесты (возможно в TestCase)
    public function testGetTagFail()
    {
        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH .'/' . 0);
        $response->assertStatus(404);
    }

    public function testUpdateTagSuccess()
    {
        $tag = factory(Tag::class)->create();
        $tagNameNew = 'New Name';

        $response = $this->actingAs($this->authUser)->json('PUT', self::API_ROOT . self::PATH .'/' . $tag->id, [
            'name' => $tagNameNew
        ]);

        $response->assertStatus(200)->assertJson([
            'name' => $tagNameNew,
        ]);
        $this->assertJsonStructure($response);
    }

    public function testDeleteTagSuccess()
    {
        $tag = factory(Tag::class)->create();
        $response = $this->actingAs($this->authUser)->json('DELETE', self::API_ROOT . self::PATH . '/' . $tag->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id
        ]);
    }

    public function testDeleteTagNotExistSuccess()
    {
        $tagId = 0;
        $response = $this->actingAs($this->authUser)->json('DELETE', self::API_ROOT . self::PATH . '/' . $tagId);

        //TODO - название таблицы вынести в константу
        $response->assertStatus(204);
        $this->assertDatabaseMissing('tags', [
            'id' => $tagId
        ]);
    }

    public function testListOfTagsWithPaginationSuccess()
    {
        $tags = factory(Tag::class, 20)->create();

        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH);
        $response->assertStatus(200);
        $this->assetJsonPaginationStructure($response);
    }

    //TODO - мб добавить в интерфейс
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
