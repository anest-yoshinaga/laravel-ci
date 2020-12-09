<?php

namespace App\Http\Middleware;

use Closure;

class IpMiddleware
{
    /**
     * 本番で公開する場合などIP遮断したい場合は
     * WHITE_IPS　をホワイトIPを設定すれば遮断される。
     * 遮断したくない場合はその設定しないようにすればいい
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $white_ip = env("WHITE_IPS", false);
        //設定されている場合はチェックする
        if ($white_ip) {
            $ips = explode(",", $white_ip);
            foreach ($ips as $ip) {
                if ($ip == $request->ip()) {
                    return $next($request);
                }
            }
            abort(403);
        } else {
            return $next($request);
        }
    }
}
