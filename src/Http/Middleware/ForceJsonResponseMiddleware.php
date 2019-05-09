<?php

namespace Rochev\Laravel\SupportTickets\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class ForceJsonResponseMiddleware
 */
class ForceJsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request Http request
     * @param Closure $next Successfully callback
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
