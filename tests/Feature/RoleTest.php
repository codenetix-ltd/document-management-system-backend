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
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();
    }

    /**
     * List of roles
     * @return void
     */
    public function testRoleList()
    {
        factory(Role::class, 10)->create();

        $response = $this->json('GET', self::API_ROOT . 'roles');

        $this->assetJsonPaginationStructure($response);
        $response->assertStatus(200);
    }

    /**
     * Get role
     * @return void
     */
    public function testRoleGet()
    {
        $roleStub = new RoleStub([], true);
        $role = $roleStub->getModel();

        $response = $this->json('GET', self::API_ROOT . 'roles/' . $role->id);

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
     * Save role
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testRoleStore()
    {
        $roleStub = new RoleStub();

        $response = $this->json('POST', self::API_ROOT . 'roles', $roleStub->buildRequest());

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
     * Save role with a validation error
     * @return void
     */
    public function testRoleStoreValidationError()
    {
        $roleStub = new RoleStub();
        $data = $roleStub->buildRequest();
        $fieldKey = 'name';
        unset($data[$fieldKey]);

        $response = $this->json('POST', self::API_ROOT . 'roles', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    /**
     * Role not found
     * @return void
     */
    public function testGetRoleNotFound()
    {
        $response = $this->json('GET', self::API_ROOT . 'roles/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Update role
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testRoleUpdate()
    {
        $roleStub = new RoleStub([], true);
        $role = $roleStub->getModel();
        $newRoleName = 'new role name';

        $response = $this->json('PUT', self::API_ROOT . 'roles/' . $role->id, $roleStub->buildRequest([
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

    /**
     * Delete role
     * @return void
     */
    public function testRoleDelete()
    {
        $roleStub = new RoleStub([], true);
        $role = $roleStub->getModel();

        $response = $this->json('DELETE', self::API_ROOT . 'roles/' . $role->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete role which does not exist
     * @return void
     */
    public function testRoleDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', self::API_ROOT . 'roles/' . 0);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
