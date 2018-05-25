<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogCollectionResource;
use App\Services\LogService;
use Illuminate\Contracts\Auth\Guard;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     * Display a listing of the resource.
     *
     * @param Guard $guard
     * @return LogCollectionResource
     */
    public function index(Guard $guard)
    {
        $user = $guard->user();
        $logs = $this->service->list($user ? $user->getAuthIdentifier() : null);

        return new LogCollectionResource($logs);
    }
}
