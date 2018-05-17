<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PermissionGroupCreateRequest;
use App\Http\Requests\PermissionGroupUpdateRequest;
use App\Http\Resources\PermissionGroupCollectionResource;
use App\Http\Resources\PermissionGroupResource;
use App\Services\PermissionGroupService;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class PermissionGroupsController extends Controller
{
    /**
     * @var PermissionGroupService
     */
    protected $service;

    /**
     * PermissionGroupsController constructor.
     * @param PermissionGroupService $service
     */
    public function __construct(PermissionGroupService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $permissionGroups = $this->service->list();
        return PermissionGroupResource::collection($permissionGroups);
    }
}
