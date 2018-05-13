<?php

namespace Tests\Feature;

use App\AccessType;
use App\Role;
use App\Services\AccessTypeService;
use App\Template;
use Tests\ApiTestCase;

class RoleTest extends ApiTestCase
{
    private const PATH = 'roles';
    protected const DB_TABLE = 'roles';

    public function testCreateRoleSuccess()
    {
        $role = factory(Role::class)->make();
        $template = factory(Template::class, 1)->create();

        $accessType = AccessType::find(AccessTypeService::TYPE_BY_QUALIFIERS);
        $permission = $accessType->permissions->first();
        $qualifiers = $permission->permissionGroup->qualifiers;
        $qualifier = $qualifiers->first();
        $qualifierAccessType = $qualifier->accessTypes->first();

        $accessTypeSimple = AccessType::where('id', '!=', AccessTypeService::TYPE_BY_QUALIFIERS)->first();
        $permissionSecond = $accessType->permissions->first(function ($value, $key) use ($permission) {
            return $value->id != $permission->id;
        });

        $permissionValues = [
            [
                'id' => $permission->id,
                'accessTypeId' => $accessType->id,
                'qualifiers' => [
                    [
                        'id' => $qualifier->id,
                        'accessTypeId' => $qualifierAccessType->id
                    ]
                ]
            ],
            [
                'id' => $permissionSecond->id,
                'accessTypeId' => $accessTypeSimple->id
            ]
        ];

        $response = $this->jsonRequestPostEntityWithSuccess(self::PATH, [
            'name' => $role->name,
            'templateIds' => $template->pluck('id'),
            'permissionValues' => $permissionValues
        ]);

        $response->assertJson([
            'name' => $role->name,
            'templateIds' => $template->pluck('id')->toArray()
        ]);
        $this->assertJsonStructure($response, array_keys(config('models.Role')));
    }

    public function testGetRoleSuccess()
    {
        $role = factory(Role::class)->create();

        $response = $this->jsonRequestGetEntitySuccess(self::PATH . '/' .  $role->id);
        $response->assertJson([
            'name' => $role->name,
        ]);
        $this->assertJsonStructure($response, array_keys(config('models.Role')));
    }

    public function testGetRoleNotFound()
    {
        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
    }

    public function testUpdateRoleSuccess()
    {
        $role = factory(Role::class)->create();
        $roleNameNew = 'New Name';

        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $role->id, [
            'name' => $roleNameNew
        ]);

        $response->assertJson([
            'name' => $roleNameNew
        ]);
        $this->assertJsonStructure($response, array_keys(config('models.Role')));
    }

    public function testDeleteRoleSuccess()
    {
        $role = factory(Role::class)->create();
        $this->jsonRequestDelete(self::PATH, $role->id, self::DB_TABLE);
    }

    public function testDeleteRoleNotExistSuccess()
    {
        $this->jsonRequestDelete(self::PATH, 0, self::DB_TABLE);
    }

    public function testListOfRolesWithPaginationSuccess()
    {
        factory(Role::class, 20)->create();

        $this->jsonRequestObjectsWithPagination(self::PATH);
    }
}
