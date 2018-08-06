<?php

namespace Tests\Feature\CommentsService;

use App\Entities\Comment;
use App\Entities\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\TestCase;
use Faker\Factory as Faker;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    /**
     * Setup the test environment.
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
        Resource::withoutWrapping();
    }

//    /**
//     * List of comments
//     * @return void
//     */
//    public function testCommentList() // .
//    {
//        $document = factory(Document::class)->create();
//        factory(Comment::class, 10)->create([
//            'commentable_id' => $document->id,
//            'commentable_type' => 'document'
//        ]);
//
//        $response = $this->json('GET', self::API_ROOT . 'comments');
//        $response->assertStatus(200); // 200 == Response::HTTP_OK
//    }

    /**
     * Get comment
     * @return void
     */
    public function testGetComment() // .
    {
        $document = factory(Document::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_id' => $document->id,
            'commentable_type' => 'document'
        ]);

        $response = $this->json('GET', self::API_ROOT . 'comments/' . $comment->id);
        $response
            ->assertStatus(200)
            ->assertJson(['commentable_id' => $document->id, 'id' => $comment->id]);
    }

    /**
     * Save comment
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testCommentStore() //.
    {
        $document = factory(Document::class)->create();
        $data = [
            'user_id' => $this->faker->randomDigitNotNull,
            'commentable_id' => $document->id,
            'commentable_type' => 'document',
            'parent_id' => $this->faker->randomDigitNotNull,
            'body' => $this->faker->text($maxNbChars = 200)
        ];

        $response = $this->json('POST', self::API_ROOT . 'comments', $data);
        $response
            ->assertStatus(201) // 201 == Response::HTTP_CREATED
            ->assertJson($data);
    }

    /**
     * Update comment
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testCommentUpdate() // .
    {
        $document = factory(Document::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_id' => $document->id
        ]);
        $data = [
            'user_id' => $this->faker->randomDigitNotNull,
            'commentable_id' => $document->id,
            'commentable_type' => 'document',
            'parent_id' => $this->faker->randomDigitNotNull,
            'body' => $this->faker->text($maxNbChars = 200)
        ];

        $response = $this->json('PUT', self::API_ROOT . 'comments/' . $comment->id, $data);
        $response
            ->assertStatus(200)
            ->assertJson($data);
    }
    /**
     * Comment not found
     * @return void
     */
    public function testGetCommentNotFound() // .
    {
        $response = $this->json('GET', self::API_ROOT . 'comments/0');
        $response
            ->assertStatus(404); //Response::HTTP_NOT_FOUND == 404
    }

    /**
     * Delete comment which does not exist
     * @return void
     */
    public function testCommentDeleteWhichDoesNotExist() // .
    {
        $response = $this->json('DELETE', self::API_ROOT . 'comments/0');
        $response->assertStatus(204);
    }

    /**
     * Delete comment
     * @return void
     */
    public function testCommentDelete() // .
    {
        $document = factory(Document::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_id' => $document->id
        ]);

        $response = $this->json('DELETE', self::API_ROOT . 'comments/' . $comment->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT); // Response::HTTP_NO_CONTENT == 204
    }
}
