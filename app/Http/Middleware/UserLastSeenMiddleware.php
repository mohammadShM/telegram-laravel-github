<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserLastSeenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth('api')->user()){
            auth('api')->user()->updateLastSeen();
        }
        return $next($request);
    }
}
