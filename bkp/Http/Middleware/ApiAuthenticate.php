<?php

namespace App\Http\Middleware;
use Auth;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Tymon\JWTAuth\JWTAuth;

class ApiAuthenticate extends Middleware
{

    /**
     *
     * @param type $request
     * @param \App\Http\Middleware\Closure $next
     * @return type
     */
    public function handle($request, Closure $next, ...$gaurds)
    {
        $origin = request()->headers->get('origin');
        $api_host = env("API_HOST");
        $api_host_arr = explode(",", $api_host);
//        \Log::info(  varDump($api_host, ' -1 ApiAuthenticate $api_host::') );
//        $token = JWTAuth::parseToken()->authenticate();
//        \Log::info(  varDump($token, ' $token ApiAuthenticate AFTER::') );

/*        \Log::info(  varDump(-1, ' -1 ApiAuthenticate Before::') );
        if (!Auth::check()) {
            \Log::info(  varDump(-2, ' -2 ApiAuthenticate Inisde::') );
            Auth::logout();
            return response()->json(['data' => "Not Authorized", 'code' => 401]);
        }
*/
        return $next($request);
        if (in_array($origin, $api_host_arr)) {
            return $next($request);
        } else {
            return response()->json(['data' => "Not Authorized", 'code' => 0]);
        }
    }

}
