<?php

namespace App\Services;

use App\Repositories\PermissionGroupRepository;
use App\System\AuthBuilders\AuthorizerFactory;
use Illuminate\Database\Eloquent\Model;

class AuthPermissions
{
    /**
     * @var PermissionGroupRepository
     */
    private $permissionGroupRepository;

    /**
     * AuthPermissions constructor.
     * @param PermissionGroupRepository $permissionGroupRepository
     */
    public function __construct(PermissionGroupRepository $permissionGroupRepository)
    {
        $this->permissionGroupRepository = $permissionGroupRepository;
    }

    /**
     * @param string $type
     * @param Model  $resource
     * @return array
     */
    public function getList(string $type, Model $resource): array
    {
        $authorizer = AuthorizerFactory::make($type, $resource);

        $permissions = $this->permissionGroupRepository->getPermissionsName($type);

        return $permissions->filter(function (&$item) use ($authorizer) {
            if ($authorizer->check($item)) {
                return $item;
            }
        })->toArray();
    }
}
