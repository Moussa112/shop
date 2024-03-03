<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function redirect;

class RedirectAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $quard = null): Response
    {
        if (Auth::guard($quard)->check() && Auth::user()->isAdmin) {
            return redirect()->route('admin.products.index');
        }

        return $next($request);
    }
}
