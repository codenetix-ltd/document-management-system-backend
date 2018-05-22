<?php

namespace Tests\Feature;

use App\Entities\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\Requests\RoleStoreRequestStub;
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

        $response->dump();

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($roleStub->buildResponse([
                'id' => $role->id,
                'createdAt' => $role->createdAt->timestamp,
                'updatedAt' => $role->updatedAt->timestamp
            ]));
    }

    /**
     * @throws \Exception
     */
    public function testRoleStore()
    {
        $roleStub = new RoleStub();

        $response = $this->json('POST', '/api/roles', $roleStub->buildRequest());
        $response->dump();

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
     * Tests role update endpoint
     *
     * @return void
     */
    public function testRoleUpdate()
    {
        $role = factory(Role::class)->create();

        $response = $this->json('PUT', '/api/roles/' . $role->id, array_only($role->toArray(), $role->getFillable()));

        $response
            ->assertStatus(200)
            ->assertJson((new RoleResource($role))->resolve());
    }

    /**
     * Tests role delete endpoint
     *
     * @return void
     */
    public function testRoleDelete()
    {
        $role = factory(Role::class)->create();

        $response = $this->json('DELETE', '/api/roles/' . $role->id);

        $response
            ->assertStatus(204);
    }

}
