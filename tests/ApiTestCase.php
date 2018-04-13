<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class ApiTestCase extends BaseTestCase
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

    protected function jsonRequest($method, $relationPath, $params = [])
    {
        return $this->actingAs($this->authUser)->json($method, self::API_ROOT . $relationPath, $params);
    }

    protected function jsonRequestPostEntityWithSuccess($relationPath, $data)
    {
        $response = $this->jsonRequest('POST', $relationPath, $data);
        $response->assertStatus(201);

        return $response;
    }

    protected function jsonRequestPostEntityValidationError($relationPath, $data = [])
    {
        $response =  $this->jsonRequest('POST', $relationPath, $data);
        $response->assertStatus(422);

        return $response;
    }

    protected function jsonRequestGetEntitySuccess($relationPath)
    {
        $response = $this->jsonRequest('GET', $relationPath);
        $response->assertStatus(200);

        return $response;
    }

    protected function jsonRequestGetEntityNotFound($relationPath)
    {
        $response = $this->jsonRequest('GET', $relationPath);
        $response->assertStatus(404);
    }

    protected function jsonRequestPutEntityWithSuccess($relationPath, $data)
    {
        $response =  $this->jsonRequest('PUT', $relationPath, $data);
        $response->assertStatus(200);

        return $response;
    }

    protected function jsonRequestDelete($path, $id, $table)
    {
        $response = $this->jsonRequest('DELETE', $path . '/' . $id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing($table, [
            'id' => $id
        ]);
    }

    protected function jsonRequestObjectsWithPagination($path)
    {
        $response = $this->jsonRequest('GET', $path);
        $response->assertStatus(200);
        $this->assetJsonPaginationStructure($response);
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

    protected function assertJsonStructure(TestResponse $response, $structure, $unsetOptionalFields = false)
    {
        $response->assertJsonStructure($this->filterStructureFields($structure, $unsetOptionalFields));
    }

    protected function filterStructureFields($structure, $unsetOptionalFields = false)
    {
        return $structure;
    }
}
