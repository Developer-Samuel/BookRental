<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class RedirectHome
{
    /**
     * Handle an incoming request.
     * Redirects requests from the root URL (/) to the /authors or /login page,
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response
    */
    public function handle(Request $request, \Closure $next): Response
    {
        if ($request->is('/')) {
            if (Auth::check()) {
                return redirect('/authors');
            }
            
            return redirect('/login');
        }

        return $next($request);
    }
}
