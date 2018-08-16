<?php

namespace Tests;

use App\Entities\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Resources\Json\Resource;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;

/**
 * Class TestCase
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const API_ROOT = '/api/v1/';

    /** @var User $authUser */
    protected $authUser;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        DB::beginTransaction();

        $this->authUser = User::whereFullName('admin')->first();
        Passport::actingAs($this->authUser);
        Resource::withoutWrapping();
    }

    /**
     * Clean up the testing environment before the next test.
     * @return void
     */
    protected function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }

    /**
     * @param TestResponse $response
     * @return void
     */
    protected function assetJsonPaginationStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'data',
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'currentPage',
                'from',
                'lastPage',
                'path',
                'perPage',
                'to',
                'total'
            ]
        ]);
    }
}
