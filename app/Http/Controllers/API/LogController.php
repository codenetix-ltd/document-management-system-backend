<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LogResource;
use App\Services\LogService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class LogController extends Controller
{
    public function index(LogService $logService, Guard $guard)
    {
        $user = $guard->user();
        $logs = $logService->list($user ? $user->id : null);

        return (LogResource::collection($logs))->response()->setStatusCode(200);
    }
}
