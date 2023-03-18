<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Guest
{
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == 'users') {
            if (!Auth::check()) {
                return Redirect::guest('login');
            }
            if (Auth::user()->status == 'Inactive') {
                $data['title'] = 'Disabled';
                Auth::logout();
                return Redirect::guest('login');
                //return \View::make('users.disabled'); //Can use in future.
            }
        } elseif ($guard == 'admin') {
            if (!Auth::guard('admin')->check()) {
                return Redirect::guest('admin/login');
            }
        }
        return $next($request);
    }
}
