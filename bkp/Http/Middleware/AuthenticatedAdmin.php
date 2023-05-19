<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

//use DB;

class AuthenticatedAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

//        $get_site_data = DB::select('SELECT site_name FROM `site_setting`');
//        $get_site_data = json_decode(json_encode($get_site_data), True);
//
//        $site_name = $get_site_data[0]['site_name'];
//        define('site_name', $site_name);

        $uri = $request->path();
        $bypass_uri = array('/stream_geeks_admin', 'stream_geeks_admin/login',
            'stream_geeks_admin/logout', 'stream_geeks_admin/forgot_password');

        if (!in_array($uri, $bypass_uri)) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user()->urole == 1) {
//                    return redirect()->route('dashboard');
                }
                if (Auth::user()->urole == 0) {
                    return redirect()->url('/');
                }
            } else {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }

}
