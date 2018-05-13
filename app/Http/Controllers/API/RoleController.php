<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;

class RoleController extends Controller
{
    public function index(RoleService $roleService)
    {
        $roles = $roleService->list();

        return (RoleResource::collection($roles))->response()->setStatusCode(200);
    }

    public function store(RoleStoreRequest $request, RoleService $roleService)
    {
        $role = $roleService->create($request->getEntity());

        return (new RoleResource($role))->response()->setStatusCode(201);
    }

    public function show(RoleService $roleService, int $id)
    {
        $role = $roleService->get($id);

        return (new RoleResource($role))->response()->setStatusCode(200);
    }

    public function update(RoleStoreRequest $request, RoleService $roleService, int $id)
    {
        $role = $roleService->update($id, $request->getEntity());

        return (new RoleResource($role))->response()->setStatusCode(200);
    }

    public function destroy(RoleService $roleService, int $id)
    {
        $roleService->delete($id);

        return response('', 204);
    }
}
