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

//    public function store(RoleStoreRequest $request, RoleService $roleService)
//    {
//        $role = $roleService->create($request->getEntity());
//
//        return (new RoleResource($role))->response()->setStatusCode(201);
//    }

//    public function show(TagService $templateGetService, int $id)
//    {
//        $template = $templateGetService->get($id);
//
//        return (new TagResource($template))->response()->setStatusCode(200);
//    }
//
//    public function update(TagUpdateRequest $request, TagService $tagUpdateService, int $id)
//    {
//        $tag = $tagUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields());
//
//        return (new TagResource($tag))->response()->setStatusCode(200);
//    }
//
//    public function destroy(TagService $userDeleteService, int $id)
//    {
//        $userDeleteService->delete($id);
//
//        return response('', 204);
//    }
}
