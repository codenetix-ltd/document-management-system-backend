<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RoleCollectionResource;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use App\System\AuthBuilders\AuthorizerFactory;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     * @return RoleCollectionResource
     */
    public function index()
    {
        $roles = $this->service->paginate();
        return new RoleCollectionResource($roles);
    }

    /**
     * @param RoleCreateRequest $request
     * @return RoleResource
     */
    public function store(RoleCreateRequest $request)
    {
        $authorizer = AuthorizerFactory::make('role');
        $authorizer->authorize('role_create');

        $role = $this->service->create($request->all());
        return new RoleResource($role);
    }

    /**
     * @param $id
     * @return RoleResource
     */
    public function show($id)
    {
        $role = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('role', $role);
        $authorizer->authorize('role_view');

        return new RoleResource($role);
    }

    /**
     * @param RoleUpdateRequest $request
     * @param $id
     * @return RoleResource
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $role = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('role', $role);
        $authorizer->authorize('role_update');

        $role = $this->service->update($request->all(), $id);
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->service->findModel($id);

        if ($role) {
            $authorizer = AuthorizerFactory::make('role', $role);
            $authorizer->authorize('role_delete');
        }

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
