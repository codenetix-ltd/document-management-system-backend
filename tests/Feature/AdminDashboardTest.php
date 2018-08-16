<?php

namespace Tests\Feature;

use App\Entities\Document;
use App\Entities\User;
use App\Services\FileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
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

        // 2 users already exists
        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=activeUsersTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'activeUsersTotal' => 8
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeUniqueVisitorsTodayTotalGreaterThanZero()
    {
        $users = factory(User::class, 6)->create();

        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=uniqueVisitorsTodayTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'uniqueVisitorsTodayTotal' => 1
            ]);

        $users[0]->update(['lastActivityAt' => Carbon::yesterday()]);
        $users->slice(2,2)->each(function($user){
            $user->update(['lastActivityAt' => Carbon::now()]);
        });

        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=uniqueVisitorsTodayTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'uniqueVisitorsTodayTotal' => 3
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeDiskSpaceUsedTotalZero()
    {
        $disk = 'document_attachments';

        /**
         * @var $fileService FileService
         */
        $fileService = app()->make(FileService::class);
        $fileService->cleanDisk($disk);

        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=diskSpaceUsedTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'diskSpaceUsedTotal' => 0
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeDiskSpaceUsedTotalGreaterThanZero()
    {
        $disk = 'document_attachments';
        $fakeFilePath = base_path('tests/FakeFiles/test.pdf');
        $fakeFileSize = ceil(filesize($fakeFilePath) / 1024);

        /**
         * @var $fileService FileService
         */
        $fileService = app()->make(FileService::class);
        $fileService->cleanDisk($disk);

        copy($fakeFilePath, $fileService->getDiskPath($disk).'/1.pdf');
        copy($fakeFilePath, $fileService->getDiskPath($disk).'/2.pdf');

        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=diskSpaceUsedTotal')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'diskSpaceUsedTotal' => $fakeFileSize * 2
            ]);
    }

    /**
     * @return void
     */
    public function testIncludeActivitiesChart()
    {
        $this
            ->json('GET', self::API_ROOT . 'dashboards/user?include=activitiesChart')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'activitiesChart' => [

                ]
            ]);
    }

}