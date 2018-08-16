<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class PermissionGroupTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
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
     * Tests permissionGroup list endpoint
     *
     * @return void
     */
    public function testPermissionGroupList()
    {
        $response = $this->json('GET', self::API_ROOT . 'permission-groups');
        $response->assertStatus(200);
    }
}
