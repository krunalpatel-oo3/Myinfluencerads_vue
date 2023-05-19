<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequestModifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /*

In laravel 8 app when I submit form I need to clear any string input with htmlspecialchars_decode and stripslashes functions. Have I to write middleware and assign it to any post/put request?

Have laravel some plugings for that to be sure that I save in db only valid data? */
        $modifiedRequest=collect($request)->map(function ($inputValue,$inputName){
            //apply ur logic here.
//            \Log::info( '-1 RequestModifier $inputValue ::' . print_r( $inputValue, true  ) );
//            \Log::info( '-2 RequestModifier RESULT $inputValue ::' . print_r( htmlspecialchars_decode(stripslashes($inputValue)), true  ) );

            return htmlspecialchars_decode(stripslashes($inputValue));

        });
        $request->replace($modifiedRequest->toArray());

        return $next($request);
    }
}
