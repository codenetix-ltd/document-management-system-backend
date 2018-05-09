<?php

namespace Tests\Feature;

use Tests\ApiTestCase;

class PermissionGroupTest extends ApiTestCase
{
    private const PATH = 'permission-groups';

    public function testListOfPermissionsSuccess()
    {
        $response = $this->jsonRequest('GET', self::PATH);
        $response->assertStatus(200);
    }
}
