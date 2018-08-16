<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Support\Facades\Auth;

class TouchCurrentUserLastActivityDateTime
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * TouchCurrentUserLastActivityTim constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $this->userService->touchUserLastActivityDateTime(Auth::user());
        }

        return $next($request);
    }
}
