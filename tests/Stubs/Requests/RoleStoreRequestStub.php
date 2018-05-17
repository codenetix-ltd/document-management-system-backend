<?php

namespace Tests\Stubs\Requests;


use App\Entities\AccessType;
use App\Entities\Permission;
use App\Entities\Role;
use App\Entities\Template;
use App\Services\AccessTypeService;

class RoleStoreRequestStub
{
    public function build(): array
    {
        $role = factory(Role::class)->make();
        $template = factory(Template::class, 1)->create();

        $permissionValue1 = $this->buildPermissionValueWithQualifiersAccessType();
        $permissionValue2 = $this->buildPermissionValueWithoutQualifiersAccessType($permissionValue1['id']);

        return [
            'name' => $role->name,
            'templateIds' => $template->pluck('id'),
            'permissionValues' => [
                $permissionValue1,
                $permissionValue2
            ]
        ];
    }

    /**
     * Build data for permission value access type = by_qualifiers
     *
     * @return array
     */
    private function buildPermissionValueWithQualifiersAccessType(): array
    {
        $accessType = AccessType::find(AccessTypeService::TYPE_BY_QUALIFIERS);
        $permission = $accessType->permissions->first();
        $qualifiers = $permission->permissionGroup->qualifiers;
        $qualifier = $qualifiers->first();
        $qualifierAccessType = $qualifier->accessTypes->first();

        return  [
            'id' => $permission->id,
            'accessTypeId' => $accessType->id,
            'qualifiers' => [
                [
                    'id' => $qualifier->id,
                    'accessTypeId' => $qualifierAccessType->id
                ]
            ]
        ];
    }

    /**
     * Build data for permission value access type != by_qualifiers
     *
     * @param array $excerptIds
     * @return array
     */
    private function buildPermissionValueWithoutQualifiersAccessType($excerptIds = []): array
    {
        $permission = Permission::where('id', '!=', $excerptIds)->first();
        $accessType = $permission->accessTypes->whereNotIn('id', AccessTypeService::TYPE_BY_QUALIFIERS)->first();

        return [
            'id' => $permission->id,
            'accessTypeId' => $accessType->id
        ];
    }
}