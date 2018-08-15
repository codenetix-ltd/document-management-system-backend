<?php

namespace App\Http\Controllers;

use App\Http\Requests\Log\LogListRequest;
use App\Http\Resources\LogCollectionResource;
use App\Services\LogService;

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
     * @param LogListRequest $request
     * @return LogCollectionResource
     */
    public function index(LogListRequest $request)
    {
        $logs = $this->service->paginate($request->queryParamsObject());

        return new LogCollectionResource($logs);
    }
}
