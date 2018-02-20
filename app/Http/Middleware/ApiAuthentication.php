<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Response;
class ApiAuthentication
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
        if (Auth::check()) {
          return $next($request);
        } else {

          $code = 403;
          return Response::json(['message' => 'Access Denied - Please Login'], $code);
        }

    }
}
