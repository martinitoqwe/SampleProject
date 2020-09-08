<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Doctor
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
    if (Auth::check() && Auth::user()->user_type == 'doctor') {
        return $next($request);
        }
        else if (Auth::check() && Auth::user()->user_type == 'patient'){
            return redirect('/index');
          //  return response(view('patients.index'));
        }
        else if (Auth::check() && Auth::user()->user_type == 'pharmacy'){
            return redirect('/pharmacy');
          //  return response(view('patients.index'));
        }
        
    }
}
