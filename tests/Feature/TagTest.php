<?php

namespace Tests\Feature;

use App\Tag;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\ApiTestCase;

class TagTest extends ApiTestCase
{
    private const PATH = 'tags';
    protected const DB_TABLE = 'tags';

    public function testCreateTagSuccess()
    {
        $tag = factory(Tag::class)->make();

        $response = $this->jsonRequestPostEntityWithSuccess(self::PATH, [
            'name' => $tag->name,
        ]);
        $response->assertJson([
            'name' => $tag->name,
        ]);
        $this->assertJsonStructure($response);
    }

    public function testCreateTagValidationError()
    {
        $response = $this->jsonRequestPostEntityValidationError(self::PATH);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testGetTagSuccess()
    {
        $tag = factory(Tag::class)->create();

        $response = $this->jsonRequestGetEntitySuccess(self::PATH . '/' .  $tag->id);
        $response->assertJson([
            'name' => $tag->name,
        ]);
        $this->assertJsonStructure($response);
    }

    public function testGetTagNotFound()
    {
        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
    }

    public function testUpdateTagSuccess()
    {
        $tag = factory(Tag::class)->create();
        $tagNameNew = 'New Name';

        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $tag->id, [
            'name' => $tagNameNew
        ]);
        $response->assertJson([
            'name' => $tagNameNew
        ]);
        $this->assertJsonStructure($response);
    }

    public function testDeleteTagSuccess()
    {
        $tag = factory(Tag::class)->create();
        $this->jsonRequestDelete(self::PATH, $tag->id, self::DB_TABLE);
    }

    public function testDeleteTagNotExistSuccess()
    {
        $this->jsonRequestDelete(self::PATH, 0, self::DB_TABLE);
    }

    public function testListOfTagsWithPaginationSuccess()
    {
        factory(Tag::class, 20)->create();

        $this->jsonRequestObjectsWithPagination(self::PATH);
    }

    private function assertJsonStructure(TestResponse $response)
    {
        $response->assertJsonStructure(config('models.tag_response'));
    }
}
