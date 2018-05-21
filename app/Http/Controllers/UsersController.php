<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     *
     * @return UserCollectionResource
     */
    public function index()
    {
        $users = $this->service->paginate();
        return new UserCollectionResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return UserResource
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->all();
        $data['avatarFileId']= $data['avatarId'];
        $user = $this->service->create($data);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return UserResource
     */
    public function show($id)
    {
        $user = $this->service->find($id);
        return new UserResource($user);
    }

    /**
     * @param UserUpdateRequest $request
     * @param $id
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->all();
        $data['avatarFileId']= $data['avatarId'];
        $user = $this->service->update($data, $id);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
