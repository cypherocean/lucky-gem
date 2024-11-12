<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
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
        // Check if the user is not authenticated
        if (!Auth::check()) {

            // Redirect to the login page if the user is not logged in
            return redirect()->route('login');
        }

        // Allow the request to continue if authenticated
        return $next($request);
    }
}
