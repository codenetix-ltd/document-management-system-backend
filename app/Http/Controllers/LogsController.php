<?php

namespace App\Http\Controllers;

use App\Entities\User;
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
     * @var RoleService
     */
    protected $roleService;

    /**
     * LogsController constructor.
     * @param LogService  $service
     * @param RoleService $roleService
     */
    public function __construct(LogService $service, RoleService $roleService)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Guard   $guard
     * @return LogCollectionResource
     */
    public function index(Request $request, Guard $guard)
    {
        $authorizer = AuthorizerFactory::make('logs');
        $authorizer->authorize('logs_view');

        /** @var User $user */
        $user = $guard->user();

        if ($user->hasAnyRole(RoleService::ROLE_ADMIN)) {
            $logs = $this->service->list(null);
        } else {
            $logs = $this->service->list($user->getAuthIdentifier());
        }

        return new LogCollectionResource($logs);
    }
}
