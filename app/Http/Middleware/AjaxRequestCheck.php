<?php

namespace App\Http\Middleware;

use Closure;

class AjaxRequestCheck
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
        if ($request->expectsJson()) {
            // this is an ajax request
            return $next($request);
        }
        return response('', 418);
    }
}
