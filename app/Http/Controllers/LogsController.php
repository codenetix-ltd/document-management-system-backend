<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\LogCreateRequest;
use App\Http\Requests\LogUpdateRequest;
use App\Http\Resources\LogCollectionResource;
use App\Http\Resources\LogResource;
use App\Services\LogService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;

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
        $logs = $this->service->list($user ? $user->id : null);

        return new LogCollectionResource($logs);
    }
}
