<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect($this->getRedirectPath($request));
            }
        }

        return $next($request);
    }

    protected function getRedirectPath(Request $request): string
    {
        if ($request->user()->role_id==1) {
            return RouteServiceProvider::DASHBOARD;
        } elseif ($request->user()->role_id==2) {
            return RouteServiceProvider::KARYAWAN;
        } else {
            return RouteServiceProvider::HOME;
        }
    }
}
