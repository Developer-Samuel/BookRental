<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class CheckAuth
{
    /**
     * Handle an incoming request.
     * Redirects the user to the login page if not authenticated.
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response
    */
    public function handle(Request $request, \Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth.show');
        }

        return $next($request);
    }
}