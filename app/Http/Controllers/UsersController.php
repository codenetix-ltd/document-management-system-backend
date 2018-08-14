<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserDestroyRequest;
use App\Http\Requests\User\UserListRequest;
use App\Http\Requests\User\UserShowRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * UsersController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @param UserListRequest $request
     * @return UserCollectionResource
     */
    public function index(UserListRequest $request)
    {
        $users = $this->service->paginate($request->queryParamsObject());
        return new UserCollectionResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->all();
        $data['avatarFileId'] = $request->get('avatarId');
        $user = $this->service->create($data);

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param UserShowRequest $request
     * @param  integer|string $id
     *
     * @return UserResource
     */
    public function show(UserShowRequest $request, string $id)
    {
        return new UserResource($request->model());
    }

    /**
     * @param UserUpdateRequest $request
     * @param integer $id
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        $data = $request->all();
        $data['avatarFileId'] = $request->get('avatarId');
        $user = $this->service->update($data, $id);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserDestroyRequest $request
     * @param  integer $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDestroyRequest $request, int $id)
    {
        $this->service->delete($id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
