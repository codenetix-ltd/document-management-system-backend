<?php

namespace Tests\Feature;

use App\Entities\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Tests\Stubs\Requests\RoleStoreRequestStub;
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
        $roles = factory(Role::class, 10)->create();

        $response = $this->json('GET', '/api/roles/' . $roles[0]->id);

        $response
            ->assertStatus(200)
            ->assertJson((new RoleResource($roles[0]))->resolve());
    }

    /**
     * Tests role store endpoint
     *
     * @return void
     */
    public function testRoleStore()
    {
        $role = (new RoleStoreRequestStub())->build();

        $response = $this->json('POST', '/api/roles', $role);

        $role = Role::where('name', $role['name'])->first();

        $response
            ->assertStatus(201)
            ->assertJson((new RoleResource($role))->resolve());
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
