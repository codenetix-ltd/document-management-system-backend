<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Services\User\UserService;

class UserController extends Controller
{
    public function index(UserService $userListService)
    {
        $users = $userListService->list();

        return (UserResource::collection($users))->response()->setStatusCode(200);
    }

    public function store(UserStoreRequest $request, UserService $userCreateService)
    {
        $user = $userCreateService->create($request->getEntity(), $request->file('avatar'));

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function show(UserService $userGetService, int $id)
    {
        $user = $userGetService->get($id);

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function update(UserUpdateRequest $request, UserService $userUpdateService, int $id)
    {
        $user = $userUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields(), $request->file('avatar'));

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function destroy(UserService $userDeleteService, int $id)
    {
        $userDeleteService->delete($id);

        return response('', 204);
    }
}
