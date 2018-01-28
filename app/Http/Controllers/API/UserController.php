<?php

namespace App\Http\Controllers\API;

use App\Contracts\Services\IUserCreateService;
use App\Contracts\Services\IUserUpdateService;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function store(UserStoreRequest $request, IUserCreateService $userCreateService)
    {
        $user = $userCreateService->create($request->getEntity(), $request->file('avatar'));

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function update(UserUpdateRequest $request, IUserUpdateService $userUpdateService, $id)
    {
        $user = $userUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields(), $request->file('avatar'));

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
