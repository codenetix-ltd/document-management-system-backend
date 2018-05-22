<?php

namespace Tests\Stubs;

use App\Entities\AccessType;
use App\Entities\Permission;
use App\Entities\Role;
use App\Entities\Template;
use App\Services\AccessTypeService;

/**
 * Class RoleStub
 * @package Tests\Stubs
 * @property Role $model
 */
class RoleStub extends AbstractStub
{
    private $templates;
    private $permissionValueWithQualifiersAccessType;
    private $permissionValueWithQualifiersAccessTypeVariableContainer;

    private $permissionValueWithoutQualifiersAccessType;

    public function __construct(array $valuesToOverride = [], bool $persisted = false)
    {
        $this->templates = factory(Template::class, 1)->create();
        $this->permissionValueWithQualifiersAccessType = $this->buildPermissionValueWithQualifiersAccessType();
        $this->permissionValueWithoutQualifiersAccessType = $this->buildPermissionValueWithoutQualifiersAccessType($this->permissionValueWithQualifiersAccessType['id']);


        parent::__construct($valuesToOverride, $persisted);
    }

    /**
     * @return string
     */
    protected function getModelName()
    {
        return Role::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [
            'name' => $this->model->name,
            'templateIds' => $this->templates->pluck('id')->toArray(),
            'permissionValues' => [
                $this->permissionValueWithQualifiersAccessType,
                $this->permissionValueWithoutQualifiersAccessType
            ]
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'name' => $this->model->name,
            'templateIds' => $this->templates->pluck('id')->toArray(),
            'permissionValues' => [
                [
                    'id' => $this->permissionValueWithQualifiersAccessType['id'],
                    'accessType' => [
                        'id' => $this->permissionValueWithQualifiersAccessTypeVariableContainer['accessType']->id,
                        'label' => $this->permissionValueWithQualifiersAccessTypeVariableContainer['accessType']->label,
                        'createdAt' => $this->permissionValueWithQualifiersAccessTypeVariableContainer['accessType']->createdAt->timestamp,
                        'updatedAt' => $this->permissionValueWithQualifiersAccessTypeVariableContainer['accessType']->updatedAt->timestamp,
                    ],
                    'qualifiers' => [
                        [
                            'id' => $this->permissionValueWithQualifiersAccessTypeVariableContainer['qualifier']->id,
                            'label' => $this->permissionValueWithQualifiersAccessTypeVariableContainer['qualifier']->label,
                            'accessType' => [
//                                'id' => $this->permissionValueWithQualifiersAccessTypeVariableContainer['qualifierAccessType']->id,
//                                'label' =>
//                                'createdAt' =>
//                                'updatedAt' =>
                            ]
                        ]
                    ]
                ]
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

        $this->permissionValueWithQualifiersAccessTypeVariableContainer['accessType'] = $accessType;
        $this->permissionValueWithQualifiersAccessTypeVariableContainer['qualifier'] = $qualifier;
        $this->permissionValueWithQualifiersAccessTypeVariableContainer['qualifierAccessType'] = $qualifierAccessType;

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