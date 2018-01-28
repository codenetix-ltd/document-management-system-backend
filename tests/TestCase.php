<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    use CreatesApplication;

    const API_ROOT = '/api/v1/';

    protected $authUser;

    public function setUp()
    {
        parent::setUp();

        $this->artisan("db:seed", ['--class' => 'TestingDataSeeder']);

        $this->authUser = User::whereFullName('admin')->first();
    }
}
