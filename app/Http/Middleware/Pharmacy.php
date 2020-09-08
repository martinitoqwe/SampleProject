<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Pharmacy
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
        if (Auth::check() && Auth::user()->user_type == 'pharmacy') {
            return $next($request);
        }
        else if (Auth::check() && Auth::user()->user_type == 'patient'){
            return redirect('/index');
          //  return response(view('patients.index'));
        }
        else if (Auth::check() && Auth::user()->user_type == 'doctor'){
            return redirect('/home');
          //  return response(view('patients.index'));
        
    }
}
}
