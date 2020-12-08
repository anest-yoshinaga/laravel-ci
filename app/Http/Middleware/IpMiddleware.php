<?php

namespace App\Http\Middleware;

use Closure;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ("production" === env("APP_ENV")) {
            $white_ip = env("WHITE_IPS", "");
            $ips = explode(",", $white_ip);
            foreach ($ips as $ip) {
                if ($ip == $request->ip()) {
                    return $next($request);
                }
            }
            abort(404);
        } else {
            return $next($request);
        }
    }
}
