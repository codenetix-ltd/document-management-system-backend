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

    /**
     * Get comment
     * @return void
     */
    public function testGetComment()
    {
        $document = factory(Document::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_id' => $document->id,
            'commentable_type' => 'document'
        ]);

        $response = $this->json('GET', self::API_ROOT . 'comments/' . $comment->id);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['commentable_id' => $document->id, 'id' => $comment->id]);
    }

    /**
     * Save comment
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testCommentStore()
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
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson($data);
    }

    /**
     * Update comment
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testCommentUpdate()
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
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($data);
    }
    /**
     * Comment not found
     * @return void
     */
    public function testGetCommentNotFound()
    {
        $response = $this->json('GET', self::API_ROOT . 'comments/0');
        $response
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Delete comment which does not exist
     * @return void
     */
    public function testCommentDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', self::API_ROOT . 'comments/0');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete comment
     * @return void
     */
    public function testCommentDelete()
    {
        $document = factory(Document::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_id' => $document->id
        ]);

        $response = $this->json('DELETE', self::API_ROOT . 'comments/' . $comment->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     *
     */
    public function testGetCommentsByRootCommentId()
    {
        $document = factory(Document::class)->create();
        $rootComment = factory(Comment::class)->create([
            'parent_id' => null,
            'commentable_id' => $document->id
        ]);

        $firstLvlComment = factory(Comment::class)->create([
            'commentable_id' => $document->id,
            'parent_id' => $rootComment->id
        ]);

        $secondLvlComment = factory(Comment::class)->create([
            'commentable_id' => $document->id,
            'parent_id' => $firstLvlComment->id
        ]);

        $response = $this->json('GET', self::API_ROOT . 'comments/' . $rootComment->id . '/children');
        dd($response);
        $response
            ->assertJson([
                [
                    'id' => '',
                    'user_id' => '',
                    'commentable_id' => '',
                    'commentable_type' => '',
                    'parent_id' => '',
                    'message' => '',
                    'created_at' => '',
                    'updated_at' => '',
                    'deleted_at' => '',
                    'children' => [

                    ]
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     *
     */
    public function testGetCommentsByDocumentId()
    {
        $document = factory(Document::class)->create();
        factory(Comment::class, 5)->create([
            'parent_id' => null,
            'commentable_id' => $document->id
        ]);
        factory(Comment::class, 10)->create([
            'commentable_id' => $document->id,
        ]);

        $response = $this->json('GET', self::API_ROOT . 'documents/' . $document->id . '/comments/tree');

        dd($response);

        $response
            ->assertJson([
                'data' => [
                    'id',
                    'userId',
                    'commentableId',
                    'commentableType',
                    'parentId',
                    'message',
                    'createdAt',
                    'updatedAt',
                    'deletedAt',
                    'children'
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }
}
