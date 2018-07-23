<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\System\AuthBuilders\AuthorizerFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     * @return UserCollectionResource
     */
    public function index()
    {
        $users = $this->service->paginate(true);
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
        $authorizer = AuthorizerFactory::make('user');
        $authorizer->authorize('user_create');

        $data = $request->all();
        $data['avatarFileId']= $data['avatarId'];
        $user = $this->service->create($data);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer|string $id
     *
     * @return UserResource
     */
    public function show(string $id)
    {
        if ($id == 'current') {
            $id = Auth::user()->id;
        }

        $user = $this->service->find($id);
        return new UserResource($user);
    }

    /**
     * @param UserUpdateRequest $request
     * @param integer           $id
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        if ($id != Auth::user()->id) {
            $user = $this->service->find($id);
            $authorizer = AuthorizerFactory::make('user', $user);
            $authorizer->authorize('user_update');
        }

        $data = $request->all();
        $data['avatarFileId']= $data['avatarId'];
        $user = $this->service->update($data, $id);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = $this->service->findModel($id);

        if ($user) {
            $authorizer = AuthorizerFactory::make('user', $user);
            $authorizer->authorize('user_delete');
        }

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
