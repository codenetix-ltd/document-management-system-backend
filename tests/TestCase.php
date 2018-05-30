<?php

namespace Tests;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

/**
 * Class TestCase
 */
abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

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

        $this->artisan("db:seed", ['--class' => 'TestingDataSeeder']);
        $this->artisan("db:seed", ['--class' => 'PermissionsSeeder']);

        $this->authUser = User::whereFullName('admin')->first();
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
