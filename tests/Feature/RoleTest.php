<?php

namespace Tests\Feature;

use App\Entities\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\RoleStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class RoleTest extends TestCase
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
        Resource::withoutWrapping();
    }

    /**
     * Tests role list endpoint
     *
     * @return void
     */
    public function testRoleList()
    {
        factory(Role::class, 10)->create();

        $response = $this->json('GET', '/api/roles');

        $this->assetJsonPaginationStructure($response);
        $response->assertStatus(200);
    }

    /**
     * Tests $role get endpoint
     *
     * @return void
     */
    public function testRoleGet()
    {
        $roleStub = new RoleStub([], true);
        $role = $roleStub->getModel();

        $response = $this->json('GET', '/api/roles/' . $role->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'id' => $role->id,
                'name' => $role->name,
                'templateIds' => [],
                'permissionValues' => [],
                'createdAt' => $role->createdAt->timestamp,
                'updatedAt' => $role->updatedAt->timestamp
            ]);
    }

    /**
     * @throws \Exception
     */
    public function testRoleStore()
    {
        $roleStub = new RoleStub();

        $response = $this->json('POST', '/api/roles', $roleStub->buildRequest());

        $role = Role::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertExactJson($roleStub->buildResponse([
                'id' => $role->id,
                'createdAt' => $role->createdAt->timestamp,
                'updatedAt' => $role->updatedAt->timestamp
            ]));
    }

    /**
     * @throws \Exception
     */
    public function testRoleStoreValidationError()
    {
        $roleStub = new RoleStub();
        $data = $roleStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);

        $response = $this->json('POST', '/api/roles', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    public function testGetRoleNotFound()
    {
        $response = $this->json('GET', '/api/roles/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @throws \Exception
     */
    public function testRoleUpdate()
    {
        $roleStub = new RoleStub([], true);
        $role = $roleStub->getModel();
        $newRoleName = 'new role name';

        $response = $this->json('PUT', '/api/roles/' . $role->id, $roleStub->buildRequest([
            'name' => $newRoleName
        ]));

        $roleUpdated = Role::find($response->decodeResponseJson('id'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($roleStub->buildResponse([
                'id' => $roleUpdated->id,
                'name' => $newRoleName,
                'createdAt' => $roleUpdated->createdAt->timestamp,
                'updatedAt' => $roleUpdated->updatedAt->timestamp
            ]));
    }

    public function testRoleDelete()
    {
        $roleStub = new RoleStub([], true);
        $role = $roleStub->getModel();

        $response = $this->json('DELETE', '/api/roles/' . $role->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRoleDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', '/api/roles/' . 0);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
