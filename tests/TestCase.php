<?php

namespace Tests;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    use CreatesApplication;

    const API_ROOT = '/api/';

    protected $authUser;

    protected function setUp()
    {
        parent::setUp();

        $this->artisan("db:seed", ['--class' => 'TestingDataSeeder']);
        $this->artisan("db:seed", ['--class' => 'PermissionsSeeder']);

        $this->authUser = User::whereFullName('admin')->first();
    }

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
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total'
            ]
        ]);
    }
}
