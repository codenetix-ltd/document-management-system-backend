<?php

namespace App\Http\Controllers\API;

use App\Contracts\Services\User\IUserCreateService;
use App\Contracts\Services\User\IUserDeleteService;
use App\Contracts\Services\User\IUserGetService;
use App\Contracts\Services\User\IUserListService;
use App\Contracts\Services\User\IUserUpdateService;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(IUserListService $userListService)
    {
        $users = $userListService->list();

        return (UserResource::collection($users))->response()->setStatusCode(200);
    }

    public function store(UserStoreRequest $request, IUserCreateService $userCreateService)
    {
        $user = $userCreateService->create($request->getEntity(), $request->file('avatar'));

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function show(IUserGetService $userGetService, int $id)
    {
        $user = $userGetService->get($id);

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function update(UserUpdateRequest $request, IUserUpdateService $userUpdateService, int $id)
    {
        $user = $userUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields(), $request->file('avatar'));

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function destroy(IUserDeleteService $userDeleteService, int $id)
    {
        $userDeleteService->delete($id);

        return response('', 204);
    }
}
