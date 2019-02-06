<?php

namespace App\Http\Middleware;

use Closure;

class TrustedIps
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
        $ips = explode(",", env("TRUSTED_IPS", "127.0.0.1,139.99.56.103"));

        if(in_array($request->ip(), $ips))
            return $next($request);
        else
            abort(404);
    }
}
