<?php

namespace App\Http\Middleware;

use Closure;

class RoleGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() === null) {
            return response('Access denied', 401);
        }
        $actions = $request->route()->getAction();
        $permissions = isset($actions['permissions']) ? $actions['permissions'] : null;

        if (!$permissions || $request->user()->hasAnyPermission($permissions)) {
            return $next($request);
        }

        return response('Access denied', 401);
    }
}
