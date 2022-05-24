<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RespondWithJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json', true);
        $request->headers->add([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);
        $request->headers->set('X-Requested-With', 'XMLHttpRequest', true);
        return $next($request);
    }
}
