<?php

namespace Tests\Stubs;

use App\Entities\AccessType;
use App\Entities\Permission;
use App\Entities\Role;
use App\Entities\Template;
use App\Services\AccessTypeService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleStub
 * @property Role $model
 */
class RoleStub extends AbstractStub
{
    /**
     * @var Collection
     */
    private $templates;

    /**
     * @var array
     */
    private $permissionValueWithQualifiersAccessType;

    /**
     * @var array
     */
    private $permissionValueWithoutQualifiersAccessType;

    /**
     * @var array
     */
    private $variablesContainer;

    /**
     * @param array   $valuesToOverride
     * @param boolean $persisted
     * @param array   $states
     * @return void
     */
    protected function buildModel(array $valuesToOverride = [], bool $persisted = false, array $states = []): void
    {
        parent::buildModel($valuesToOverride, $persisted, $states);

        $this->templates = factory(Template::class, 1)->create();
        $this->permissionValueWithQualifiersAccessType = $this->buildPermissionValueWithQualifiersAccessType();
        $this->permissionValueWithoutQualifiersAccessType = $this->buildPermissionValueWithoutQualifiersAccessType($this->permissionValueWithQualifiersAccessType['id']);
    }

    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return Role::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [
            'name' => $this->model->name,
            'templatesIds' => $this->templates->pluck('id')->toArray(),
            'permissionValues' => [
                $this->permissionValueWithQualifiersAccessType,
                $this->permissionValueWithoutQualifiersAccessType
            ]
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'name' => $this->model->name,
            'templatesIds' => $this->templates->pluck('id')->toArray(),
            'permissionValues' => [
                [
                    'id' => $this->permissionValueWithQualifiersAccessType['id'],
                    'accessType' => [
                        'id' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['accessType']->id,
                        'label' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['accessType']->label,
                        'createdAt' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['accessType']->createdAt->timestamp,
                        'updatedAt' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['accessType']->updatedAt->timestamp,
                    ],
                    'qualifiers' => [
                        [
                            'id' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifier']->id,
                            'label' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifier']->label,
                            'accessType' => [
                                'id' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifierAccessType']->id,
                                'label' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifierAccessType']->label,
                                'createdAt' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifierAccessType']->createdAt->timestamp,
                                'updatedAt' => $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifierAccessType']->updatedAt->timestamp,
                            ]
                        ]
                    ]
                ],
                [
                    'id' => $this->permissionValueWithoutQualifiersAccessType['id'],
                    'accessType' => [
                        'id' => $this->variablesContainer['permissionValueWithoutQualifiersAccessType']['accessType']->id,
                        'label' => $this->variablesContainer['permissionValueWithoutQualifiersAccessType']['accessType']->label,
                        'createdAt' => $this->variablesContainer['permissionValueWithoutQualifiersAccessType']['accessType']->createdAt->timestamp,
                        'updatedAt' => $this->variablesContainer['permissionValueWithoutQualifiersAccessType']['accessType']->updatedAt->timestamp,
                    ],
                    'qualifiers' => []
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

        $this->variablesContainer['permissionValueWithQualifiersAccessType']['accessType'] = $accessType;
        $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifier'] = $qualifier;
        $this->variablesContainer['permissionValueWithQualifiersAccessType']['qualifierAccessType'] = $qualifierAccessType;

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
     * @param integer $excerptId
     * @return array
     */
    private function buildPermissionValueWithoutQualifiersAccessType(int $excerptId): array
    {
        $permission = Permission::where('id', '!=', $excerptId)->first();
        $accessType = $permission->accessTypes->whereNotIn('id', AccessTypeService::TYPE_BY_QUALIFIERS)->first();

        $this->variablesContainer['permissionValueWithoutQualifiersAccessType']['accessType'] = $accessType;

        return [
            'id' => $permission->id,
            'accessTypeId' => $accessType->id
        ];
    }
}
