<?php

namespace Tests\Feature;

use App\Entities\Document;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();
    }

    /**
     * @return void
     */
    public function testEmpty()
    {
        $this
            ->json('GET', self::API_ROOT . 'dashboards/user')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(0);
    }

    /**
     * @return void
     */
    public function testIncludeActiveDocumentTotalZero()
    {
        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=activeDocumentsTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'activeDocumentsTotal' => 0
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeActiveDocumentTotalGreaterThanZero()
    {
        $documents = factory(Document::class, 5)->create();
        $documents[0]->substituteDocumentId = $documents[1]->id;
        $documents[0]->save();

        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=activeDocumentsTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'activeDocumentsTotal' => 4
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeActiveUsersTotalZero()
    {
        // 2 users already exists
        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=activeUsersTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'activeUsersTotal' => 2
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeActiveUsersGreaterThanZero()
    {
        factory(User::class, 6)->create();

        //@TODO disable some users

        // 6 users already exists
        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=activeUsersTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'activeUsersTotal' => 6
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeUniqueVisitorsTodayTotalGreaterThanZero()
    {
        factory(User::class, 6)->create();

        //@TODO disable some users

        // 6 users already exists
        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=uniqueVisitorsTodayTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'activeUsersTotal' => 6
            ]);
    }
}