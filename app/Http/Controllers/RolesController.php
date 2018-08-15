<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleDestroyRequest;
use App\Http\Requests\Role\RoleListRequest;
use App\Http\Requests\Role\RoleShowRequest;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Resources\RoleCollectionResource;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Response;

class RolesController extends Controller
{
    /**
     * @var RoleService
     */
    protected $service;

    /**
     * RolesController constructor.
     * @param RoleService $service
     */
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    /**
     * @param RoleListRequest $request
     * @return RoleCollectionResource
     */
    public function index(RoleListRequest $request)
    {
        $roles = $this->service->paginate($request->queryParamsObject());
        return new RoleCollectionResource($roles);
    }

    /**
     * @param RoleStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleStoreRequest $request)
    {
        $role = $this->service->create($request->all());
        return (new RoleResource($role))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param RoleShowRequest $request
     * @param integer         $id
     * @return RoleResource
     */
    public function show(RoleShowRequest $request, int $id)
    {
        return new RoleResource($request->model());
    }

    /**
     * @param RoleUpdateRequest $request
     * @param integer           $id
     * @return RoleResource
     */
    public function update(RoleUpdateRequest $request, int $id)
    {
        $role = $this->service->update($request->all(), $id);
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     * @param RoleDestroyRequest $request
     * @param  integer            $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleDestroyRequest $request, int $id)
    {
        $this->service->delete($id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
