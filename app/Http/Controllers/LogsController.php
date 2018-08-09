<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Requests\LogListRequest;
use App\Http\Resources\LogCollectionResource;
use App\Services\LogService;
use App\Services\RoleService;
use App\System\AuthBuilders\AuthorizerFactory;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * @var LogService
     */
    protected $service;

    /**
     * LogsController constructor.
     * @param LogService $service
     */
    public function __construct(LogService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Guard   $guard
     * @return LogCollectionResource
     */
    public function index(LogListRequest $request, Guard $guard)
    {

        //dd($request->queryParamsObject()->getSortsData());
//        $authorizer = AuthorizerFactory::make('logs');
//        $authorizer->authorize('logs_view');

        /** @var User $user */
//        $user = $guard->user();
//
//        if ($user->hasAnyRole(RoleService::ROLE_ADMIN)) {
//            $logs = $this->service->list(null, true);
//        } else {
//            $logs = $this->service->list($user->getAuthIdentifier(), true);
//        }

        $logs = $this->service->list($request->queryParamsObject());

        return new LogCollectionResource($logs);
    }
}
