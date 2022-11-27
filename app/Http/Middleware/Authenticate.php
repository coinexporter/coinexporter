<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
        if (! $request->expectsJson()) {
            if($request->is('nupe') || $request->is('nupe/*'))
            {
                 return route('login');
            }
            else
            {
                Session::flash('error', "Please Register or Login to view this page.");
                return route('user.login');
            }
            
        }
    }
}


