<?php

namespace Tests\Feature\CommentsService;

use App\Entities\Comment;
use App\Entities\Document;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\TestCase;
use Faker\Factory as Faker;

class CommentTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @var Faker $faker
     */
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
     * Clean up the testing environment before the next test.
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
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
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $document = factory(Document::class)->create();
        $data = [
            'user_id' => $user->id,
            'commentable_id' => $document->id,
            'commentable_type' => 'document',
            'parent_id' => $comment->id,
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
        $user = factory(User::class)->create();
        $document = factory(Document::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_id' => $document->id
        ]);
        $data = [
            'user_id' => $user->id,
            'commentable_id' => $document->id,
            'commentable_type' => 'document',
            'parent_id' => null,
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
     * Get comments by root comment id
     * @return void
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

        $thirdLvlComment = factory(Comment::class)->create([
            'commentable_id' => $document->id,
            'parent_id' => $secondLvlComment->id
        ]);

        $response = $this->json('GET', self::API_ROOT . 'comments/' . $rootComment->id . '/children');
        $response
            ->assertJson([
                [
                    'id' => $firstLvlComment->id,
                    'user_id' => $firstLvlComment->user_id,
                    'commentable_id' => $firstLvlComment->commentable_id,
                    'commentable_type' => $firstLvlComment->commentable_type,
                    'parent_id' => $firstLvlComment->parent_id,
                    'body' => $firstLvlComment->body,
                    'created_at' => $firstLvlComment->created_at->timestamp,
                    'updated_at' => $firstLvlComment->updated_at->timestamp,
                    'deleted_at' => $firstLvlComment->deleted_at,
                    'children' => [
                        [
                            'id' => $secondLvlComment->id,
                            'user_id' => $secondLvlComment->user_id,
                            'commentable_id' => $secondLvlComment->commentable_id,
                            'commentable_type' => $secondLvlComment->commentable_type,
                            'parent_id' => $secondLvlComment->parent_id,
                            'body' => $secondLvlComment->body,
                            'created_at' => $secondLvlComment->created_at->timestamp,
                            'updated_at' => $secondLvlComment->updated_at->timestamp,
                            'deleted_at' => $secondLvlComment->deleted_at,
                            'children' => [
                                [
                                    'id' => $thirdLvlComment->id,
                                    'user_id' => $thirdLvlComment->user_id,
                                    'commentable_id' => $thirdLvlComment->commentable_id,
                                    'commentable_type' => $thirdLvlComment->commentable_type,
                                    'parent_id' => $thirdLvlComment->parent_id,
                                    'body' => $thirdLvlComment->body,
                                    'created_at' => $thirdLvlComment->created_at->timestamp,
                                    'updated_at' => $thirdLvlComment->updated_at->timestamp,
                                    'deleted_at' => $thirdLvlComment->deleted_at,
                                    'children' => []
                                ]
                            ]
                        ]
                    ]
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test getting comments by document id
     * @return void
     */
    public function testGetCommentsByDocumentId()
    {
        $document = factory(Document::class)->create();

        $rootComment = factory(Comment::class)->create([
            'parent_id' => null,
            'commentable_id' => $document->id
        ]);

        $firstLvlComments = factory(Comment::class, 2)->create([
            'parent_id' => $rootComment->id,
            'commentable_id' => $document->id
        ]);

        $secondLvlComment = factory(Comment::class)->create([
            'parent_id' => $firstLvlComments[1]->id,
            'commentable_id' => $document->id
        ]);

        $response = $this->json('GET', self::API_ROOT . 'documents/' . $document->id . '/comments/tree');
        $response
            ->assertJson([
                [
                    'id' => $rootComment->id,
                    'user_id' => $rootComment->user_id,
                    'commentable_id' => $rootComment->commentable_id,
                    'commentable_type' => $rootComment->commentable_type,
                    'parent_id' => $rootComment->parent_id,
                    'body' => $rootComment->body,
                    'created_at' => $rootComment->created_at->timestamp,
                    'updated_at' => $rootComment->updated_at->timestamp,
                    'deleted_at' => $rootComment->deleted_at,
                    'children' => [
                        [
                            'id' => $firstLvlComments[0]->id,
                            'user_id' => $firstLvlComments[0]->user_id,
                            'commentable_id' => $firstLvlComments[0]->commentable_id,
                            'commentable_type' => $firstLvlComments[0]->commentable_type,
                            'parent_id' => $firstLvlComments[0]->parent_id,
                            'body' => $firstLvlComments[0]->body,
                            'created_at' => $firstLvlComments[0]->created_at->timestamp,
                            'updated_at' => $firstLvlComments[0]->updated_at->timestamp,
                            'deleted_at' => $firstLvlComments[0]->deleted_at,
                            'children' => []
                        ],

                        [
                            'id' => $firstLvlComments[1]->id,
                            'user_id' => $firstLvlComments[1]->user_id,
                            'commentable_id' => $firstLvlComments[1]->commentable_id,
                            'commentable_type' => $firstLvlComments[1]->commentable_type,
                            'parent_id' => $firstLvlComments[1]->parent_id,
                            'body' => $firstLvlComments[1]->body,
                            'created_at' => $firstLvlComments[1]->created_at->timestamp,
                            'updated_at' => $firstLvlComments[1]->updated_at->timestamp,
                            'deleted_at' => $firstLvlComments[1]->deleted_at,
                            'children' => [
                                [
                                    'id' => $secondLvlComment->id,
                                    'user_id' => $secondLvlComment->user_id,
                                    'commentable_id' => $secondLvlComment->commentable_id,
                                    'commentable_type' => $secondLvlComment->commentable_type,
                                    'parent_id' => $secondLvlComment->parent_id,
                                    'body' => $secondLvlComment->body,
                                    'created_at' => $secondLvlComment->created_at->timestamp,
                                    'updated_at' => $secondLvlComment->updated_at->timestamp,
                                    'deleted_at' => $secondLvlComment->deleted_at,
                                    'children' => []
                                ]
                            ]
                        ]
                    ]
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testGetCommentsWithIncorrectPageNumber()
    {
        $document = factory(Document::class)->create();
        $response = $this->json('GET', self::API_ROOT . 'documents/' . $document->id . '/comments/tree?pageNumber=-4');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
