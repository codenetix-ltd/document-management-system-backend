<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class PermissionGroupTest extends TestCase
{
    use RefreshDatabase;

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
