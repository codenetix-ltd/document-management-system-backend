<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleListRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RoleCollectionResource;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use App\System\AuthBuilders\AuthorizerFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @param RoleCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleCreateRequest $request)
    {
        $authorizer = AuthorizerFactory::make('role');
        $authorizer->authorize('role_create');

        $role = $this->service->create($request->all());
        return (new RoleResource($role))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param integer $id
     * @return RoleResource
     */
    public function show(int $id)
    {
        $role = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('role', $role);
        $authorizer->authorize('role_view');

        return new RoleResource($role);
    }

    /**
     * @param RoleUpdateRequest $request
     * @param integer $id
     * @return RoleResource
     */
    public function update(RoleUpdateRequest $request, int $id)
    {
        $role = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('role', $role);
        $authorizer->authorize('role_update');

        $role = $this->service->update($request->all(), $id);
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $role = $this->service->find($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        $authorizer = AuthorizerFactory::make('role', $role);
        $authorizer->authorize('role_delete');

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
